<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;

class SendBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:send:balance {usbNum?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get balance and send';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // sudo gammu getussd '*0800#'
        // $usbNum = $this->argument('usbNum') ?? "0";
        $usbList = [
            1 => "99364765192",
            6 => "99364746854"
        ];

        foreach ($usbList as $usbNum => $phoneNumber){

            $process = Process::fromShellCommandline('gammu -s ' . $usbNum . ' getussd *0800# | grep "Service reply"');

            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                $sms = "Sms center: {$phoneNumber} - error!";
            } else {
                $sms = $process->getOutput();

                $sms = Str::after($sms, 'balansynyz');
    
                $sms = "Sms center: {$phoneNumber} balance - $sms";
            }

            $process = new Process([
                'gammu',
                "-s",
                1,
                'sendsms',
                'TEXT',
                "99362624628",
                '-text',
                $sms
            ]);

            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }
    }
}
