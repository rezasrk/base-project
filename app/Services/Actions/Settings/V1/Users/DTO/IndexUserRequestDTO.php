<?php

namespace App\Services\Actions\Settings\V1\Users\DTO;

class IndexUserRequestDTO
{
    public function __construct(
        private ?string $username = null,
        private ?string $fullName = null,
        private ?array $roles = null
    ) {
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getRoles(): ?array
    {
        return array_filter($this->roles);
    }
}
