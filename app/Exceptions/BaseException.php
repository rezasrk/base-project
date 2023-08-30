<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    public function __construct(string $message = 'Exception', int $code = 0, array $extra = [])
    {
        parent::__construct(
            message: $message,
            code: $code
        );
    }
}
