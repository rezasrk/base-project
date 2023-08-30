<?php

namespace App\Services\Actions\Profile\DTO;

class ShowUserProfileRequestDTO
{
    public function __construct(
        private int $userId
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
