<?php

namespace App\Http\Controllers\Admin\USB;

use App\Models\Usb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'phone'      => 'required|string',
            'port_numbers' => 'required|string',
            'is_active' => 'nullable'
        ]);

        $usb = Usb::create([
            'phone'     => $data['phone'],
            'port_numbers' => array_map('intval', explode(',', $data['port_numbers'])),
            'is_active' => Arr::exists($data, 'is_active'),
        ]);


        return redirect()->back();
    }
}
