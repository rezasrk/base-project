<?php

namespace App\Services\Actions\Settings\V1\Users\DTO;


class UpdateUserRequestDTO extends UpdateOrCreateUserRequestDTO
{
    public function __construct(
        private int $userId,
        private string $username,
        private string $name,
        private string $family,
        private array $projects,
        private array $requestStatuses,
        private array $requestTypes,
        private array $roles,
        private ?string $password = null
    ) {
        parent::__construct(
            $username,
            $name,
            $family,
            $projects,
            $requestStatuses,
            $requestTypes,
            $roles,
            $password
        );
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
