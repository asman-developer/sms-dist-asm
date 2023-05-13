<?php

namespace Database\Seeders;

use App\Models\Usb;
use Illuminate\Database\Seeder;

class UsbSeeder extends Seeder
{
    public function run()
    {
        Usb::wherePhone(99364765192)->firstOr(function () {
            Usb::create([
                'phone'         => 99364765192,
                'port_numbers'  => [1,3]
            ]);
        });

        Usb::wherePhone(99364746854)->firstOr(function () {
            Usb::create([
                'phone'         => 99364746854,
                'port_numbers'  => [4,6]
            ]);
        });
    }
}
