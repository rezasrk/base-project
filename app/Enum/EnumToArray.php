<?php

namespace App\Enum;

trait EnumToArray
{
    public static function names(): array
    {
        return collect(RequestStatusEnum::cases())->map(function ($enum) {
            return $enum->name;
        })->all();
    }

    public static function values(): array
    {
        return collect(RequestStatusEnum::cases())->map(function ($enum) {
            return $enum->value;
        })->all();
    }
}
