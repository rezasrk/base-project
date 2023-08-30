<?php

namespace App\Services\Actions\Auth\DTO;

class SelectProjectRequestDTO
{
    public function __construct(
        private int $userId,
        private int $projectId
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }
}
