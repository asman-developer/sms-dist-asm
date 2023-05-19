<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RefreshGammuConf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:gammu:conf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh gammu config file';
    /**

     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        new Process([
            'supervisorctl stop all && gammu-detect > ~/.gammurc && sleep 30 && supervisorctl start all'
        ]);
    }
}
