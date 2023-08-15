<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('gammu:handle')->cron("*/5 * * * * *");
        // $schedule->command('gammu:send:balance 3')->dailyAt('9:00');
        // $schedule->command('gammu:send:balance')->dailyAt('9:00');
        // $schedule->command('gammu:send:balance')->everyFiveMinutes();
//         $schedule->command('app:sms:bomb')->everyMinute();
        // $schedule->command('refresh:gammu:conf')->everySixHours();
        $schedule->command('get:customers:otp')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
