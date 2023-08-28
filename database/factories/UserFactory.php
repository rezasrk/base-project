<?php

namespace Database\Factories;

use App\Enum\UserEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'family' => $this->faker->name(),
            'username' => $this->faker->userName(),
            'personality' => UserEnum::PANEL->value,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ];
    }
}
