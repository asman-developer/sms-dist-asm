<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::whereName("SHOP")->firstOr(function () {
            Service::create([
                "trans"  => json_encode([
                    "ru" => "ASMANSHOP",
                    "tm" => "ASMANSHOP"
                ], true),
                "name" => "SHOP",
                "token" => "ijjthUAP0cqkH7TOPAvjAsAZDtvdzaJV"
            ]);
        });

        Service::whereName("ASMAN_MARKET")->firstOr(function () {
            Service::create([
                "trans"  => json_encode([
                    "ru" => "ASMAN-MARKET",
                    "tm" => "ASMAN-MARKET"
                ], true),
                "name" => "ASMAN_MARKET",
                "token" => "ijjthUAP0cqkH7TOPAvBBsAZDtvdzaJV"
            ]);
        });
        Service::whereName("DISTRIBUTION_MARKETING")->firstOr(function () {
            Service::create([
                "trans" => json_encode([
                    "ru" => "РАССЫЛКИ-МАРКЕТИНГ",
                    "tm" => "PAÝLAMALAR-MARKETING"
                ], true),
                "name"  => "DISTRIBUTION_MARKETING",
                "token" => "ijjthUAP0cqkH7TOPAvBCsAZDtvdzaJV"
            ]);
        });
        Service::whereName("DISTRIBUTION_KREDIT")->firstOr(function () {
            Service::create([
                "trans" => json_encode([
                    "ru" => "РАССЫЛКИ-КРЕДИТ",
                    "tm" => "PAÝLAMALAR-KREDIT"
                ], true),
                "name"  => "DISTRIBUTION_KREDIT",
                "token" => "wZY7P3tOANPScRB20IiAUxTgU3ak5M"
            ]);
        });
    }
}
