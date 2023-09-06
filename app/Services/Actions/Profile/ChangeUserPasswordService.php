<?php

namespace App\Services\Actions\Profile;

use App\Models\User;
use App\Services\Actions\Profile\DTO\ChangeUserPasswordRequestDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangeUserPasswordService
{
    public function handle(ChangeUserPasswordRequestDTO $changeUserPasswordRequestDTO)
    {
        $user = User::query()->findOrFail($changeUserPasswordRequestDTO->getUserId());

        $checkPassword = Hash::check(
            $changeUserPasswordRequestDTO->getOldPassword(),
            $user->password
        );

        if (! $checkPassword) {
            throw ValidationException::withMessages(['old_password' => __('messages.old_password_wrong')]);
        }

        $user->update(['password' => Hash::make($changeUserPasswordRequestDTO->getNewPassword())]);
    }
}
