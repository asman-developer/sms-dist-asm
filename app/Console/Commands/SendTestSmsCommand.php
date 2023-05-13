<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SendTestSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:test {phone} {usbNum?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sms test';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $usbNum = $this->argument('usbNum') ?? "0";

        // gammu sendsms TEXT +70001234567 -text "Test message"
        $process = new Process([
            'gammu',
            "-s",
            $usbNum,
            'sendsms',
            'TEXT',
            $this->argument("phone"),
            '-text',
            'Gammu test message'
        ]);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());
    }
}
