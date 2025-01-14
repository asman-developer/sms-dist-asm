<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(StaffSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(UsbSeeder::class);
        $this->call(ServiceSyncUsbSeeder::class);
        $this->call(StaffSyncServiceSeeder::class);
    }
}
