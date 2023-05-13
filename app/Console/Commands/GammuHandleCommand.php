<?php

namespace App\Console\Commands;

use App\Models\SMS;
use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GammuHandleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:handle {usbNum}';

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
        $s = 180;
        $usbNum = $this->argument("usbNum");

        $tick = 0;

        while($tick < 180) { 

            $pending = SMS::whereStatus(0)
                        ->whereRaw("TIMESTAMPDIFF(SECOND, created_at, NOW()) < $s")
                        ->whereDate("created_at", now())
                        ->where("process_number", '=', $usbNum)
                        ->get();
            
            $pending->each(function($sms) use ($usbNum){

                // $this->info("handle - $sms->id");
                $process = new Process([
                    'gammu', 
                    "-s", 
                    $usbNum,
                    'sendsms',
                    'TEXT',
                    "+{$sms->phone}",
                    '-text',
                    "{$sms->content}"
                ]);

                $process->run();

                // executes after the command finishes
                if (!$process->isSuccessful()) {
                    $sms->touch();
                    return;
                    // throw new ProcessFailedException($process);
                }

                $sms->status = 1;
                $sms->save();
                // $this->info($process->getOutput());
            });

            if ($pending->isEmpty()) {
                sleep(5);
                $tick = $tick + 5;
                $this->info($tick);
            }
        }
    }
}
