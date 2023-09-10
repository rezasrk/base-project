<?php

namespace App\Services\Actions\Settings\V1\Users\DTO;

use Illuminate\Support\Facades\Hash;

class UpdateOrCreateUserRequestDTO
{
    public function __construct(
        private string $username,
        private string $name,
        private string $family,
        private array $projects,
        private array $requestStatuses,
        private array $requestTypes,
        private array $roles,
        private ?string $password = null
    ) {
    }

    public function getUserPayload(): array
    {
        return collect([
            'username' => $this->username,
            'name' => $this->name,
            'family' => $this->family,
            'password' => $this->password ? Hash::make($this->password) : null,
            'access_request' => [
                'statuses' => $this->requestStatuses,
                'types' => $this->requestTypes,
            ],
        ])->filter()
            ->all();
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
