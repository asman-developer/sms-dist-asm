<?php

namespace App\Http\Controllers\Admin\USB;

use App\Models\Service;
use App\Models\Usb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $usb = Usb::query()->findOrFail($request->id);

        $usb->delete();

        return redirect()->back();
    }
}
