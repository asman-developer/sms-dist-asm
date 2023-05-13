<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SendTestLongSMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send:long-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test long text';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $content = "Salam hormatly musderi Gylyjow Sohbet Atamyradowic. Sizin 25.09.2022 senesinde 'Berkarar' sowda-dync alys merkezindaki 'ALTIN YILDIZ' magazynyndan 1468 manat mocberinde alan esiginizin kreditinin aylyk toleginin 1469 manadyny 25.03.2023 senesinde tolemelidiginizi yatladyarys. Habarlasmak ucin telefon belgimiz +993 64 75-22-48.";

        $process = Process::fromShellCommandline('echo "$MESSAGE" | sudo gammu sendsms TEXT "$PHONE" -len "$LENGHT"');

        $process->run(null, [
            'MESSAGE' => $content,
            'PHONE'   => '+99362615986',
            'LENGHT'  => strlen($content)
        ]);

        echo $process->getOutput();
    }
}
