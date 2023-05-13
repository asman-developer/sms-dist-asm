<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Jobs\CreateMessagesJob;
use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $staff = currentStaff();

        $data = $request->validate([
            'name'       => 'required',
            'start_time' => 'required',
            'excel_link' => 'required',
            'service_id' => 'required',
            'is_active' =>  'nullable',
        ]);

        $fileLink = base_path("public/{$data['excel_link']}");

        if (!File::exists($fileLink)) return redirect()->back()->withErrors(['excel_link' => 'required']);

        $distribution = Distribution::create([
            'name'       => $data['name'],
            'start_time' => $data['start_time'],
            'excel_link' => base_path("public/{$data['excel_link']}"),
            'service_id' => $data['service_id'],
            'is_active'     => Arr::exists($data, 'is_active')
        ]);

        CreateMessagesJob::dispatch($distribution);

        return redirect()->back();
    }
}
