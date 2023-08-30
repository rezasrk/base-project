<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition()
    {
        return [
            'project_title' => $this->faker->name(),
        ];
    }

    public function inActive()
    {
        return $this->state(function () {
            return [
                'is_active' => 0,
            ];
        });
    }

    public function active()
    {
        return $this->state(function () {
            return [
                'is_active' => 0,
            ];
        });
    }
}
