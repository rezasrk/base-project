<?php

namespace App\Services\Actions\Settings\V1\Users;

use App\Models\User;
use App\Services\Actions\Settings\V1\Users\DTO\UpdateUserRequestDTO;
use Illuminate\Support\Facades\DB;

class UpdateUserService
{
    public function handle(UpdateUserRequestDTO $updateUserRequestDTO): void
    {
        DB::transaction(function () use ($updateUserRequestDTO) {

            $user = User::query()->findOrFail($updateUserRequestDTO->getUserId());

            $user->update($updateUserRequestDTO->getUserPayload());

            $user->projects()->sync($updateUserRequestDTO->getProjects());

            $user->roles()->sync($updateUserRequestDTO->getRoles());
        });
    }
}
