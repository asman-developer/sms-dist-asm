<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSyncServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staffs = Staff::query()->get();

        foreach ($staffs as $staff){
            $services = Service::pluck('id')->toArray();
            $staff->services()->sync($services);
        }
    }
}
