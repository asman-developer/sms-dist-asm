<?php

namespace Database\Factories;

use App\Models\SMS;
use Illuminate\Database\Eloquent\Factories\Factory;

class SMSFactory extends Factory
{
    protected $model = SMS::class;

    public function definition()
    {
        return [
            'service_id' => 2,
            'phone' => $this->faker->randomElement([99365657369, 99362615986]),
            'content' => $this->faker->text(10)
        ];
    }
}
