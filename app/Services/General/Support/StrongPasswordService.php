<?php

namespace App\Services\General\Support;

class StrongPasswordService
{
    public static function check(string $password): bool
    {
        preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,190}/', $password, $result);

        return count($result) > 0;
    }
}
