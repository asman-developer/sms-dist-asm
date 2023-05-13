<?php

namespace App\Http\Controllers\Admin\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string',
            'name_ru'   => 'required|string',
            'name_tm'   => 'required|string',
            'is_active' => 'nullable',
            'service_usbs'      => 'required|array'
        ]);

        $service = Service::create([
            'name'      => $data['name'],
            'trans'     => json_encode([
                "ru" => $data['name_ru'],
                "tm" => $data['name_tm']
            ],true),
            'token'     => Str::random(30),
            'is_active' => Arr::exists($data, 'is_active'),
        ]);

        if (Arr::exists($data, 'service_usbs')){
            $service->usbList()->sync($data['service_usbs']);
        }

        return redirect()->back();
    }
}
