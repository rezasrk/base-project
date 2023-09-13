<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BaseinfoFactory extends Factory
{
    public function definition()
    {
        return [
            'type' => $this->faker->name(),
            'value' => $this->faker->name(),
        ];
    }
}
