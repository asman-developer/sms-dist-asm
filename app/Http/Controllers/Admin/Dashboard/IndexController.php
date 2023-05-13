<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SMS;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $currentStaff = currentStaff();

        $services = $currentStaff->services()->get();

        $otp_messages = $this->getMessagesByDate($request);
        
        return view('pages.dashboard.index', compact('services', 'otp_messages'));
    }

    private function getMessagesByDate($request)
    {
        $data = SMS::query()
            ->select([
                DB::raw('COUNT(id) as count'),
                DB::raw('count(case when status = 1 then 1 else null end) as complete_count'),
                DB::raw('count(case when status = 0 then 1 else null end) as error_count')
            ])
            ->unless($request->type == '30-day', function($q) {
                $from = now()->startOfDay();
                $to = now()->endOfDay();
                return $q
                    ->addSelect(DB::raw("HOUR(created_at) as day"))
                    ->whereBetween('created_at', [$from, $to]);
            })
            ->when($request->type == '30-day', function($q) {
                $from = now()->subDay(30);
                $to = now();
                return $q
                    ->addSelect(DB::raw("DATE(created_at) as day"))
                    ->whereBetween('created_at', [$from, $to]);
            })
            ->whereNull('distribution_id')
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        return [
            'success_data' => $data->pluck('complete_count'),
            'error_data' => $data->pluck('error_count'),
            'categories' => $request->type == 'today' ? $data->pluck('day')->map(fn ($day) => "{$day} : 00") : $data->pluck('day'),
            'total_messages' => $data->sum('count'),
            'total_error_messages' => $data->sum('error_count'),
            'total_success_messages' => $data->sum('complete_count'),
        ];
    }
}
