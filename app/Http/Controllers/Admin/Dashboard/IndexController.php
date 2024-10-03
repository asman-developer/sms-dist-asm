<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Models\SMS;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $currentStaff = currentStaff();

        $services = $currentStaff->services()->get();

        $messages = $this->getMessagesByDate($request, $currentStaff, $services);
        
        return view('pages.dashboard.index', compact('services', 'messages'));
    }

    private function getMessagesByDate($request, $staff, $services)
    {
        if($request->type != '30-day'){
            $from = now()->startOfDay();
            $to = now()->endOfDay();
        } else {
            $from = now()->subDay(30);
            $to = now();
        }

        $distributionIds = Distribution::query()
            ->whereBetween('created_at', [$from, $to])
            ->whereIn('service_id', $services->pluck('id')->toArray())
            ->get()
            ->pluck('id')
            ->toArray();

        $data = SMS::query()
            ->select([
                DB::raw('COUNT(id) as count'),
                DB::raw('count(case when status = 1 then 1 else null end) as complete_count'),
                DB::raw('count(case when status = 0 then 1 else null end) as error_count')
            ])
            ->unless($request->type == '30-day', function($q) {
                return $q
                    // ->addSelect(DB::raw("HOUR(created_at) as day"));
                    ->addSelect(DB::raw("EXTRACT(HOUR FROM created_at) as day")); // HOUR() yerine EXTRACT() kullanıldı

            })
            ->when($request->type == '30-day', function($q) {
                return $q
                    ->addSelect(DB::raw("DATE(created_at) as day"));
            })
            ->whereBetween('created_at', [$from, $to])
            ->when($staff->role == RoleEnum::MANAGER->value, function($q)use ($distributionIds){
                return $q->whereIn('distribution_id', $distributionIds);
            })
            ->unless($staff->role == RoleEnum::MANAGER->value, function($q){
                return $q->whereNull('distribution_id');
            })
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
