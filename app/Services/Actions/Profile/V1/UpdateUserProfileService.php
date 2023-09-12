<?php

namespace App\Services\Actions\Profile\V1;

use App\Models\User;
use App\Services\Actions\Profile\V1\DTO\UpdateUserProfileRequestDTO;

class UpdateUserProfileService
{
    public function handle(UpdateUserProfileRequestDTO $updateUserProfileRequestDTO)
    {
        $user = User::query()->findOrFail($updateUserProfileRequestDTO->getUserId());

        $user->update([
            'username' => $updateUserProfileRequestDTO->getUsername(),
            'email' => $updateUserProfileRequestDTO->getEmail(),
            'name' => $updateUserProfileRequestDTO->getName(),
            'family' => $updateUserProfileRequestDTO->getFamily(),
        ]);
    }
}
