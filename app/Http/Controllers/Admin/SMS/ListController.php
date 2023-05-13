<?php

namespace App\Http\Controllers\Admin\SMS;

use App\Enums\RoleEnum;
use App\Enums\ServicesEnum;
use App\Models\Service;
use App\Models\SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $currentStaff = currentStaff();

        $messages = $currentStaff->messages()
            ->when($request->filled('q'), function($query) use ($request){
                return $query
                    ->where('phone', 'LIKE' ,"%{$request->q}%");
            })
            ->when($request->filled('distribution_id'), function($query) use ($request){
                return $query
                    ->where('distribution_id', $request->distribution_id);
            })
            ->when($request->filled('service_id'), function($query) use ($request){
                return $query
                    ->where('service_id', $request->service_id);
            })
            ->when($request->filled('status'), function($query) use ($request){
                return $query
                    ->where('status', $request->status - 1);
            })
            ->when($request->filled('type'), function($query) use ($request){
                return $query
                    ->where('type', $request->type - 1);
            })
            ->orderBy('id','DESC')
            ->paginate(20)
            ->appends(request()->query());

        $currentStaff->load('services');

        $services = $currentStaff->services()->whereIsActive(true)->get();

        return view('pages.sms.index', compact('messages', 'services'));
    }
}
