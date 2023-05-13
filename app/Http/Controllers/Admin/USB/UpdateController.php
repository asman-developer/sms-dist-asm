<?php

namespace App\Http\Controllers\Admin\USB;

use App\Models\Service;
use App\Models\Usb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $usb = Usb::query()->findOrFail($request->id);

        $data = $request->validate([
            'phone'      => 'required|string',
            'port_numbers' => 'required|string',
            'is_active' => 'nullable'
        ]);

        $ports = array_map('intval', explode(',', $data['port_numbers']));

        $usb->update([
            'phone'     => $data['phone'],
            'port_numbers' => $ports,
            'is_active' => Arr::exists($data, 'is_active'),
        ]);
        return redirect()->back();
    }
}
