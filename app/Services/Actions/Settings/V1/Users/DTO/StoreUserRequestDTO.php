<?php

namespace App\Services\Actions\Settings\V1\Users\DTO;

class StoreUserRequestDTO extends UpdateOrCreateUserRequestDTO
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
}
