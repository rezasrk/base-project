<?php

namespace App\Services\Actions\Profile\V1\DTO;

class UpdateUserProfileRequestDTO
{
    public function __construct(
        private int $userId,
        private string $username,
        private string $email,
        private string $name,
        private string $family
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamily(): string
    {
        return $this->family;
    }
}
