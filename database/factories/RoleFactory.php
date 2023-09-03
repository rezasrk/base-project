<?php

namespace Database\Factories;

use App\Enum\RoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'guard_name' => 'sanctum',
            'status' => 1,
        ];
    }
}
