<?php

namespace App\Http\Controllers\Admin\Service;

use App\Models\Service;
use App\Models\Usb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $currentStaff = currentStaff();

        $services = Service::query()->paginate(10);
        $usbList = Usb::query()->whereIsActive(true)->get();

        return view('pages.service.index', compact('services', 'usbList'));
    }
}
