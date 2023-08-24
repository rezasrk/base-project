<?php

namespace App\Services\Actions\Auth\DTO;

class LoginResponseDTO
{
    public function __construct(
        private string $token,
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
