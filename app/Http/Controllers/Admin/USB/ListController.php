<?php

namespace App\Http\Controllers\Admin\USB;

use App\Models\Usb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $usbList = Usb::query()->paginate(10);

        return view('pages.usb.index', compact('usbList'));
    }
}
