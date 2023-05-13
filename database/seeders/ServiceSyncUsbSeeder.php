<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Usb;
use Illuminate\Database\Seeder;

class ServiceSyncUsbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $usbList = Usb::where('phone', '99364765192')->orWhere('phone', '99364746854')->pluck('id')->toArray();

        Service::whereName("SHOP")->first()
            ->usbList()
            ->sync([1,2]);

        Service::whereName("ASMAN_MARKET")->first()
            ->usbList()
            ->sync([1,2]);

        Service::whereName("DISTRIBUTION_MARKETING")->first()
            ->usbList()
            ->sync([1]);

        Service::whereName("DISTRIBUTION_KREDIT")->first()
            ->usbList()
            ->sync([1]);
    }
}
