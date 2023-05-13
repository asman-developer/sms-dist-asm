<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InsertErrorJob implements ShouldQueue
{
    use Dispatchable;
    use Queueable;

    protected $trace;
    protected $message;
    protected $time;

    public function __construct($message, $trace, Carbon $time)
    {
        $this->message = $message;
        $this->trace = $trace;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::connection('asman_analytics')
        ->table('service_errors')
        ->insert([
            'service_name'    => 'SMS',
            'id'              => (string)Str::uuid(),
            'name'            => 'ERROR',
            'error'           => $this->message,
            'trace'           => json_encode($this->trace),
            'occurred_at'     => $this->time
        ]);
    }
}
