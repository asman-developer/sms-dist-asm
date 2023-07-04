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
            // ->where('name', "SHOP_OTP")
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




// <?php

// namespace App\Console\Commands;

// use App\Models\Service;
// use App\Models\SMS;
// use App\Models\Usb;
// use Illuminate\Console\Command;
// use Illuminate\Support\Arr;
// use Symfony\Component\Process\Process;
// use Spatie\Async\Pool;
// use SplQueue;
// use Symfony\Component\Process\Exception\ProcessFailedException;
// use Throwable;

// class GammuAsyncHandleCommand extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'gammu:async:handle';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Async Sms handle by gammu';

//     /**
//      * Execute the console command.
//      *
//      * @return mixed
//      */
//     public function handle()
//     {
//         $s = 180;
//         $tick = 0;

//         $usbList = Service::with('usbList')
//             ->where('name', "ASMAN_MARKET_OTP")
//             ->get()
//             ->pluck('usbList')
//             ->collapse();

//         $usbIds = $usbList->keyBy('port_numbers.0');

//         while($tick < 180) {

//             $chunked = SMS::whereStatus(0)
//                         ->whereNull('distribution_id')
//                         ->where("created_at", '>', now()->subSeconds(110))
//                         ->orderBy('id', 'desc')
//                         ->get()
//                         ->chunk(count($usbList));

//             $pool = Pool::create()->concurrency(count($usbList));

//             foreach ($chunked as $pending) {

//                 $usbQueue = $this->getUSBQueue($usbList);

//                 foreach ($pending as $sms) {
//                     if ($sms->created_at->diffInSeconds(now()) > 110 || $sms->tries >= 2) {
//                         continue;
//                     }

//                     // $usbQueue = $usbQueue->isEmpty() ? $this->getUSBQueue($usbList) : $usbQueue;

//                     // $usbNum = $usbQueue->dequeue();

//                     $usbNum = $this->getEmptyUsb($usbQueue);

//                     $usbQueue[$usbNum] = 1;

//                     $smsCallback = $this->handleSMS($sms->phone, $sms->content, $usbNum);

//                     $pool
//                         ->add($smsCallback)
//                         ->then(function ($output) use ($sms, $usbNum, $usbIds) {
//                             $sms->status = 1;
//                             $sms->usb_id = $usbIds[$usbNum]->id;
//                             $sms->completed_at = now();
//                             $sms->save();
//                         })->catch(function (Throwable $exception) use ($sms, $usbNum, &$usbList, $usbIds) {
//                             $sms->usb_id = $usbIds[$usbNum]->id;
//                             $sms->tries = $sms->tries + 1;
//                             $sms->save();
//                             $usbList->reject(fn($v, $k) => $v == $usbNum);
//                         });
//                 }

//                 $pool->wait();
//             }

//             if ($chunked->isEmpty()) {
//                 sleep(5);
//                 $tick = $tick + 5;
//             }
//         }
//     }

//     private function getEmptyUsb($usbQueue) {
//         $usbNum = Arr::where($usbQueue, function ($value, $key) { return $value == 0; });
        
//         return Arr::random(array_keys($usbNum));
//     }

//     public function getUSBQueue($usbList){
//         $usbQueue=null;

//         $list = $usbList
//             ->pluck('port_numbers')
//             ->unique()
//             ->collapse()
//             ->shuffle();

//         foreach($list as $usb) {
//             $usbQueue[$usb] = 0;
//         }

//         return $usbQueue;
//     }

//     public function handleSMS($phone, $content, $usbNum)
//     {
//         // 1, 2 - 99364765192
//         // 3, 4 - 99364746854
//         return function () use ($phone, $content, $usbNum) {
//                 $process = new Process([
//                     'gammu',
//                     "-s",
//                     $usbNum,
//                     'sendsms',
//                     'TEXT',
//                     "+{$phone}",
//                     '-text',
//                     "{$content}"
//                 ]);

//                 $process->run();

//                 if (!$process->isSuccessful()) {
//                     throw new ProcessFailedException($process);
//                 }
//         };
//     }

//     public function handleSMSFromShell($phone, $content, $usbNum)
//     {
//         $process = Process::fromShellCommandline('echo -e "$MESSAGE" | sudo gammu -s "$USBNUM" sendsms TEXT "$PHONE" -len "$LENGHT"');

//         $process->run(null, [
//             'MESSAGE' => $content,
//             'PHONE'   => $phone,
//             'USBNUM'  => $usbNum,
//             'LENGHT'  => 400
//         ]);

//         $process->run();

//         if (!$process->isSuccessful()) {
//             throw new ProcessFailedException($process);
//         }
//     }
// }
