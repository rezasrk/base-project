<?php

namespace Database\Factories\Supply;

use App\Enum\Supply\CategoryDisciplineEnum;
use App\Enum\Supply\CategoryUnitEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[0-9]{2}'),
            'category_title' => $this->faker->name(),
            'category_parent_id' => 0,
            'discipline_id' => CategoryDisciplineEnum::GENERAL->value,
            'unit_id' => CategoryUnitEnum::KILO_GRAM->value,
            'is_product' => 0,
        ];
    }
}
