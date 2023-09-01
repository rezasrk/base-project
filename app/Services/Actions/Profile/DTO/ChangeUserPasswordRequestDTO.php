<?php

namespace App\Services\Actions\Profile\DTO;

class ChangeUserPasswordRequestDTO
{
    public function __construct(
        private int $userId,
        private string $oldPassword,
        private string $newPassword
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}
