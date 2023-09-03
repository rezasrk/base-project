<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'parent_id' => 0,
            'status' => 1,
            'guard_name' => 'sanctum',
        ];
    }
}
