<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $staff = currentStaff();

        $staff->load('services');

        $services = $staff->services()->orderBy('id','DESC')->get();

        $serviceIds = $services->pluck('id')->toArray();

        $distributions = Distribution::query()
            ->whereIn('service_id', $serviceIds)
            ->orderBy('id','DESC')
            ->paginate(20);

        return view('pages.distribution.index', compact('distributions', 'services'));
    }
}
