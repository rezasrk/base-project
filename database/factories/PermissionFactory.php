<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'title' => $this->faker->name(),
            'family' => $this->faker->name(),
            'is_parent' => 1,
            'status' => 1,
            'guard_name' => 'sanctum',
        ];
    }
}
