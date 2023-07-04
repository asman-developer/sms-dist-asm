<?php

namespace App\Console\Commands;

use App\Enums\DistributionStatesEnum;
use App\Models\Distribution;
use App\Models\Usb;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
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
                ->with(['service.usbList','messages'])
                ->whereServiceId($serviceId)
                ->where('state', '=', DistributionStatesEnum::PENDING)
                ->where('start_time', '<=', now())
                ->whereIsActive(true)
                ->first();
                
            if ($distribution != null){
                $usbList = $distribution->service->usbList;
                    // ->toArray();

                $usbIds = $usbList->keyBy('port_numbers.0');

                $poolMessages = Pool::create()->concurrency(count($usbList));

                $completeCount = $distribution->completed_count;

                releoadChunk:
                    $chunkMessage = $distribution
                        ->messages()
                        ->whereStatus(0)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->chunk(count($usbList));

                foreach($chunkMessage as $messages){

                    $usbQueue = $this->getUSBQueue($usbList);

                    foreach ($messages as $sms) {
                        if ($sms->tries >= 3) {
                            continue;
                        }

                        $usbNum = Arr::where($usbQueue, function ($value, $key) { return $value == 0; });

                        if (!count($usbNum)){
                            $poolMessages->wait();
                            goto releoadChunk;
                        }
        
                        $usbNum = Arr::random(array_keys($usbNum));

                        $usbQueue[$usbNum] = 1;

                        $smsCallback = $this->handleSMS($sms->phone, $sms->content, $usbNum);
                        // $smsCallback  = fn () => true;

                        $poolMessages
                            ->add($smsCallback)
                            ->then(function ($output) use ($sms, $usbNum, &$completeCount, $usbIds) {
                                // executes after the command finishes
                                $sms->status = 1;
                                $sms->usb_id = $usbIds[$usbNum]->id;
                                $sms->completed_at = now();
                                $sms->save();

                                $completeCount++;
                            })->catch(function (Throwable $exception) use ($sms, $usbNum, $usbIds, &$usbList) {
                                $sms->usb_id = $usbIds[$usbNum]->id;
                                $sms->tries = $sms->tries + 1;
                                $sms->save();
                                $usbList = $usbList->reject(fn($v, $k) => $v->id == $usbIds[$usbNum]->id);
                            });

                        if(!$distribution->is_active){
                            die();
                        }
                    }

                    $poolMessages->wait();

                    $distribution->completed_count = $completeCount;
                    $distribution->save();
                    // sleep(10);
                    if ($this->permissionToDistribution()){
                        die();
                    }
                }
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
    
    public function getUSBQueue($usbList){
        $usbQueue=null;

        $list = $usbList
            ->pluck('port_numbers')
            ->unique()
            ->collapse()
            ->shuffle();

        foreach($list as $usb) {
            $usbQueue[$usb] = 0;
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
