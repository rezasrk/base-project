<?php

namespace App\Services\Actions\Settings\V1\Users;

use App\Models\User;
use App\Services\Actions\Settings\V1\Users\DTO\StoreUserRequestDTO;
use Illuminate\Support\Facades\DB;

class StoreUserService
{
    public function handle(StoreUserRequestDTO $storeUserRequestDTO)
    {
        DB::transaction(function () use ($storeUserRequestDTO) {
            $user = User::query()->create($storeUserRequestDTO->getUserPayload());

            $user->roles()->sync($storeUserRequestDTO->getRoles());

            $user->projects()->sync($storeUserRequestDTO->getProjects());
        });
    }
}
