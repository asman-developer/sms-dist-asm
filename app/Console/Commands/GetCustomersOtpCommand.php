<?php

namespace App\Console\Commands;

use App\Jobs\SendSMSJob;
use App\Models\SMS;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetCustomersOtpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:customers:otp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get customers otp';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = 'https://customers.asmanexpress.com/otp';

        $response = Http::acceptJson()->get($url)->json();

        foreach ($response as $data){
            // dd($data);
            $prepare = SMS::wherePhone($data['phone'])
                ->whereBetween('created_at', [now()->subMinutes(2), now()])
                ->exists();

            if (!$prepare){
                $sms = SMS::create([                
                    'service_id'    => 3,
                    'phone'         => $data['phone'],
                    'content'       => $data['otp'],
                ]);
                
                SendSMSJob::dispatch($sms);
            }
        }
    }
}
