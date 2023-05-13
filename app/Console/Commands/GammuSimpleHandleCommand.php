<?php

namespace App\Console\Commands;

use App\Models\SMS;
use Illuminate\Console\Command;
use SplQueue;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GammuSimpleHandleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:handle {--s|seconds=1 : seconds ago}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sms handle by gammu';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $s = $this->option("seconds") ?? 60;

        $tick = 0;

        while($tick < 60) { 

            $pending = SMS::whereStatus(0)
                        ->whereRaw("TIMESTAMPDIFF(SECOND, created_at, NOW()) < $s")
                        ->whereDate("created_at", now())
                        ->get();

            $usbList = [1, 2];

            $usbQueue = new SplQueue();

            foreach($usbList as $usb) {
                $usbQueue[] = $usb;
            }

            $pending->each(function($sms) use ($usbList, $usbQueue){

                // $this->info("handle - $sms->id");

                $usbQueue->isEmpty() ? $usbQueue->rewind() : null;
                
                $usbNum = $usbQueue->dequeue();
            
                $process = new Process([
                    'gammu', 
                    "-s", 
                    $usbNum,
                    'sendsms',
                    'TEXT',
                    "+{$sms->phone}",
                    '-text',
                    "{$sms->content} - {$usbNum}"
                ]);

                $process->run();

                // executes after the command finishes
                if (!$process->isSuccessful()) {
                    $sms->touch();
                    throw new ProcessFailedException($process);
                }

                $sms->status = 1;
                $sms->save();

                // $this->info($process->getOutput());
            });

            // sleep(5);

            $tick = $tick + 5;

            $this->info($tick);
        }
    }
}
