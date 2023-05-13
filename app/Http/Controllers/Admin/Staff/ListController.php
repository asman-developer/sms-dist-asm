<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Enums\RoleEnum;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $staffs = Staff::query()->with('services')->paginate(20);
        $services = Service::query()->whereIsActive(true)->get();
        $roles = RoleEnum::asArray();
        return view('pages.staff.index', compact('staffs', 'services', 'roles'));
    }
}
