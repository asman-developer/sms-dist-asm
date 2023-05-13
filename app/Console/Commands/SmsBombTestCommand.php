<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\SMS;
use Illuminate\Console\Command;
use SplQueue;

class SmsBombTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sms:bomb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating bunch of sms for testing';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $phones = [
            '99362615986', // mohamed
            // '99361711765', // dagdan
            // '99363536153', // wepa,
            // '99364620954', // maksat
            '99365657369', // reshit
        ];

        $times = 50;

        for ($i=0; $i < $times; $i++) { 
            foreach($phones as $phone) {
                SMS::create([
                    'service_id'     => random_int(1, 2),
                    'phone'          => $phone,
                    'content'        => random_int(00000, 99999),
                ]);
            }
        }
    }
}
