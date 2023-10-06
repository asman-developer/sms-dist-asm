<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InComeMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sms:income {from?} {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Income message';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        info('OK');
        info($this->argument('from'));
        info($this->argument('message'));
    }
}
