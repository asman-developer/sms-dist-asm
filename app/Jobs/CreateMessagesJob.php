<?php

namespace App\Jobs;

use App\Excel\ExcelImportCollection;
use App\Models\Distribution;
use App\Models\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class CreateMessagesJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $distribution;

    public function __construct(Distribution $distribution)
    {
        $this->distribution = $distribution;
    }

    public function handle()
    {
        $distribution = $this->distribution;

        $list = Excel::ToCollection(
            new ExcelImportCollection(),
            $distribution->excel_link
        );

        $count = 0;

        $list->first()
            ->map(function($row) use ($distribution, &$count){
                if ($row->get(0) == 'PHONE NUMBER' || $row->get(0) == null || $row->get(1) == null) {
                    return;
                }

                $count++;

                SMS::create([
                    'service_id'        => $distribution->service->id,
                    'phone'             => $row->get(0),
                    'content'           => $row->get(1),
                    'distribution_id'   => $distribution->id
                ]);

            });

        $distribution->message_count = $count;
        $distribution->state = 1;
        $distribution->save();
    }
}
