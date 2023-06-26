<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\SMS;
use App\Models\Usb;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Spatie\Async\Pool;
use SplQueue;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Throwable;

class GammuAsyncHandleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:async:handle';

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
        $s = 180;
        $tick = 0;

        $usbList = Service::with('usbList')
            ->where('name', "SHOP_OTP")
            ->orWhere('name', "ASMAN_MARKET_OTP")
            ->get()
            ->pluck('usbList')
            ->collapse()
            ->pluck('port_numbers')
            ->unique()
            ->collapse()
            ->shuffle()
            ->toArray();

        while($tick < 180) {

            $chunked = SMS::whereStatus(0)
                        ->whereNull('distribution_id')
                        ->where("created_at", '>', now()->subSeconds(110))
                        ->orderBy('id', 'desc')
                        ->get()
                        ->chunk(count($usbList));

            $usbQueue = $this->getUSBQueue($usbList);

            $pool = Pool::create()->concurrency(count($usbList));

            $chunked->each(function($pending) use ($usbQueue, $pool, $usbList){

                foreach ($pending as $sms) {
                    if ($sms->created_at->diffInSeconds(now()) > 110 || $sms->tries >= 2) {
                        return;
                    }

                    $usbQueue = $usbQueue->isEmpty() ? $this->getUSBQueue($usbList) : $usbQueue;

                    $usbNum = $usbQueue->dequeue();

                    $smsCallback = $this->handleSMS($sms->phone, $sms->content, $usbNum);

                    $pool
                        ->add($smsCallback)
                        ->then(function ($output) use ($sms, $usbNum) {
                            // executes after the command finishes
                            $usbId = Usb::whereJsonContains('port_numbers', $usbNum)->first()->id;
                            $sms->status = 1;
                            $sms->usb_id = $usbId;
                            $sms->completed_at = now();
                            $sms->save();
                        })->catch(function (Throwable $exception) use ($sms, $usbNum) {
                            $this->info($exception->getMessage());
                            $usbId = Usb::whereJsonContains('port_numbers', $usbNum)->first()->id;
                            $sms->usb_id = $usbId;
                            $sms->tries = $sms->tries + 1;
                            $sms->save();
                        });
                }
                
                $pool->wait();
            });

            if ($chunked->isEmpty()) {
                sleep(5);
                $tick = $tick + 5;
            }
        }
    }

    public function getUSBQueue(array $usbList) : SplQueue {
        $usbQueue = new SplQueue();

        foreach($usbList as $usb) {
            $usbQueue[] = $usb;
        }

        return $usbQueue;
    }

    public function handleSMS($phone, $content, $usbNum)
    {
        // 1, 2 - 99364765192
        // 3, 4 - 99364746854
        return function () use ($phone, $content, $usbNum) {
                $process = new Process([
                    'gammu',
                    "-s",
                    $usbNum,
                    'sendsms',
                    'TEXT',
                    "+{$phone}",
                    // '-flash',
                    '-text',
                    // "{$content} - {$usbNum}"
                    "{$content}"
                ]);

                $process->run();

                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
        };
    }

    public function handleSMSFromShell($phone, $content, $usbNum)
    {
        $process = Process::fromShellCommandline('echo -e "$MESSAGE" | sudo gammu -s "$USBNUM" sendsms TEXT "$PHONE" -len "$LENGHT"');

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
    }
}
