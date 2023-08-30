<?php

namespace App\Services\Actions\Profile\DTO;

use Illuminate\Http\UploadedFile;

class UpdateUserProfileRequestDTO
{
    public function __construct(
        private int $userId,
        private string $username,
        private string $email,
        private string $name,
        private string $family,
        private ?UploadedFile $uploadedFile = null
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

    public function getSignFile(): ?UploadedFile
    {
        return $this->uploadedFile;
    }
}
