<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition()
    {
        return [
            'firstname'         => $this->faker->firstName(),
            'lastname'          => $this->faker->lastName(),
            'email'             => $this->faker->unique()->safeEmail(),
            'phone'             => $this->faker->numberBetween(11111111111, 99999999999),
            'password'          => Hash::make(123123), // password
            'remember_token'    => Str::random(10),
        ];
    }
}
