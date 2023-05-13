<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GetBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:balance {usbNum?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get balance';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // sudo gammu getussd '*0800#'
//        $usbNum = $this->argument('usbNum') ?? "0";

        $process = new Process([
            'gammu',
            'getussd',
            '*0800#'
        ]);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());
    }
}
