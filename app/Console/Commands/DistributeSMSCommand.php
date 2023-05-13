<?php

namespace App\Console\Commands;

use App\Enums\DistributionStatesEnum;
use App\Models\Distribution;
use App\Models\Usb;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Spatie\Async\Pool;
use SplQueue;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Throwable;

class DistributeSMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:distribute:sms {--service=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Async Sms handle by gammu';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $serviceId = $this->option('service');

        if (is_null($serviceId)) {
            die();
        }

        $tick = 0;

        while ($tick < 180) {

            if ($this->permissionToDistribution()){
                sleep(3600);
                continue;
            }

            $distribution = Distribution::query()
                ->with('messages')
                ->whereServiceId($serviceId)
                ->where('state', '=', DistributionStatesEnum::PENDING)
                ->where('start_time', '<=', now())
                ->whereIsActive(true)
                ->first();
                
            if ($distribution != null){
                $usbList = $distribution
                    ->service
                    ->usbList
                    ->pluck('port_numbers')
                    ->unique()
                    ->collapse()
                    ->toArray();

                $chunkMessage = $distribution
                    ->messages()
                    ->whereStatus(0)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->chunk(count($usbList));

                $usbQueue = $this->getUSBQueue($usbList);

                $poolMessages = Pool::create()->concurrency(count($usbList));

                $completeCount = $distribution->completed_count;

                $chunkMessage
                    ->each(function ($messages) use ($poolMessages, $usbQueue, $usbList, &$completeCount, &$distribution) {
                        foreach ($messages as $sms) {
                            if ($sms->tries >= 3) {
                                continue;
                            }

                            $usbQueue = $usbQueue->isEmpty() ? $this->getUSBQueue($usbList) : $usbQueue;

                            $usbNum = $usbQueue->dequeue();

                            $smsCallback = $this->handleSMS($sms->phone, $sms->content, $usbNum);
                            // $smsCallback  = fn () => true;

                            $poolMessages
                                ->add($smsCallback)
                                ->then(function ($output) use ($sms, $usbNum, &$completeCount) {
                                    // executes after the command finishes
                                    $usbId = Usb::whereJsonContains('port_numbers', $usbNum)->first()->id;
                                    $sms->status = 1;
                                    $sms->usb_id = $usbId;
                                    $sms->completed_at = now();
                                    $sms->save();

                                    $completeCount++;
                                })->catch(function (Throwable $exception) use ($sms, $usbNum) {
                                    $this->info($exception->getMessage());
                                    $usbId = Usb::whereJsonContains('port_numbers', $usbNum)->first()->id;
                                    $sms->usb_id = $usbId;
                                    $sms->tries = $sms->tries + 1;
                                    $sms->save();
                                });
                        }

                        $poolMessages->wait();

                        $distribution->completed_count = $completeCount;
                        $distribution->save();
                        sleep(10);
                        if ($this->permissionToDistribution()){
                            die();
                        }
                    });
                $distribution->state = DistributionStatesEnum::COMPLETED;
                $distribution->completed_at = now();
                $distribution->save();
            }
            sleep(5);
            $tick = $tick + 5;
        }
    }

    public function handleSMS($phone, $content, $usbNum)
    {
        return function () use ($phone, $content, $usbNum) {

            $textLength = strlen($content);

            $process = new Process([
                'gammu',
                "-s",
                $usbNum,
                'sendsms',
                'TEXT',
                "+{$phone}",
                '-text',
                "{$content}",
                "-len",
                "{$textLength}",
                "-unicode"
            ]);

            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        };
    }

    public function handleSMSFromShell($phone, $content, $usbNum)
    {
        return function () use ($phone, $content, $usbNum) {
            $process = Process::fromShellCommandline('echo "$MESSAGE" | sudo gammu -s "$USBNUM" sendsms TEXT "$PHONE" -len "$LENGHT"');

            $process->run(null, [
                'MESSAGE' => $content,
                'PHONE'   => $phone,
                'USBNUM'  => $usbNum,
                'LENGHT'  => 400
            ]);

            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        };
    }

    public function getUSBQueue(array $usbList) : SplQueue {
        $usbQueue = new SplQueue();

        foreach($usbList as $usb) {
            $usbQueue[] = $usb;
        }

        return $usbQueue;
    }

    private function permissionToDistribution() : bool
    {
        $time = Carbon::now();
        $startTime = Carbon::create($time->year, $time->month, $time->day, 8, 0, 0);
        $endTime = Carbon::create($time->year, $time->month, $time->day, 22, 0, 0);

        return !$time->between($startTime, $endTime, true);
    }
}
