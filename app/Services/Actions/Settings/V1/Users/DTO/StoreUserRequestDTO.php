<?php

namespace App\Services\Actions\Settings\V1\Users\DTO;

class StoreUserRequestDTO
{
    public function __construct(
        private string $username,
        private string $name,
        private string $family,
        private string $password,
        private array $projects,
        private array $requestStatuses,
        private array $requestTypes,
        private array $roles
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamily(): string
    {
        return $this->family;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function getRequestStatuses(): array
    {
        return $this->requestStatuses;
    }

    public function getRequestTypes(): array
    {
        return $this->requestTypes;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
