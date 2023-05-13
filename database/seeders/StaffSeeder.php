<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run()
    {
        Staff::wherePhone(99362615986)->firstOr(function () {
            Staff::create([
                'email'     => 'hojayevkoch@gmail.com',
                'phone'     => 99362615986,
                'password'  => Hash::make('123123'),
                'firstname' => 'Mohamed',
                'lastname'  => 'Hojayev',
                'role'      => RoleEnum::ADMIN
            ]);
        });

        Staff::wherePhone(99365657369)->firstOr(function () {
            Staff::create([
                'email'     => 'acerkezov97@gmail.com',
                'phone'     => 99365657369,
                'password'  => Hash::make('123123'),
                'firstname' => 'Cherkezov',
                'lastname'  => 'Abdylreshit',
                'role'      => RoleEnum::ADMIN
            ]);
        });

        Staff::wherePhone(99363536153)->firstOr(function () {
            Staff::create([
                'email'     => 'asmantiz.com@gmail.com',
                'phone'     => 99363536153,
                'password'  => Hash::make('123123'),
                'firstname' => 'Wepaly',
                'lastname'  => 'asd',
                'role'      => RoleEnum::ADMIN
            ]);
        });
    }
}
