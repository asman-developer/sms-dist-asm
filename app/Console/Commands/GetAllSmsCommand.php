<?php

namespace App\Console\Commands;

use App\Models\Usb;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GetAllSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:getallsms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all sms';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $usbList = Usb::query()->whereIsActive(true)->get();

        foreach ($usbList as $usb){

            $ports = $usb->port_numbers;

            foreach ($ports as $port){
                $isSuccess = false;

                $command = "gammu -s {$port} getallsms";

                $process = Process::fromShellCommandline( $command . '| grep "SMS parts in"');

                $process->run();

                if ($process->isSuccessful()) {
                    $isSuccess = true;
                    break;
                }
            }

//            if ($isSuccess){
//
//            }

            $sms = $process->getOutput();

            $sms = Str::after($sms, 'balansynyz');

        }

        $this->info($process->getOutput());
    }
}
