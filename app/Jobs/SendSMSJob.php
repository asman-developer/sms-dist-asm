<?php

namespace App\Jobs;

use App\Models\SMS;
use App\Models\Usb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Arr;

class SendSMSJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    protected $sms;
    protected $usbNum;

    public function __construct(SMS $sms)
    {
        $this->sms = $sms;

        $usbList = $sms->service->usbList()->get()->pluck('port_numbers')->collapse()->toArray();

        $this->usbNum = $sms->usb_id ? Arr::random($sms->usb->port_numbers) : $usbList[array_rand($usbList)];
    }

    public function handle()
    {
        $textLength = $textLength = strlen($this->sms->content);
        
        $process = new Process([
            'gammu',
            "-s",
            $this->usbNum,
            'sendsms',
            'TEXT',
            "+{$this->sms->phone}",
            '-text',
            "{$this->sms->content}",
            "-len",
            "{$textLength}",
            "-unicode"
        ]);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            $this->sms->touch();
            throw new ProcessFailedException($process);
        }
        
        $usbId = Usb::whereJsonContains('port_numbers', $this->usbNum,)->first()->id;

        $this->sms->status = 1;
        $this->sms->usb_id = $usbId;
        $this->sms->status = 1;
        $this->sms->completed_at = now();
        $this->sms->save();
    }
}
