<?php

namespace App\Services\Actions\Profile;

use App\Models\User;
use App\Services\Actions\Profile\DTO\UpdateUserProfileRequestDTO;

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

        if (!is_null($updateUserProfileRequestDTO->getSignFile())) {
            $path = $updateUserProfileRequestDTO->getSignFile()->store('signature');
            $user->update(['signature_path' => $path]);
        }
    }
}
