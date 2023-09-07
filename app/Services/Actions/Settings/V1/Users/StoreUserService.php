<?php

namespace App\Services\Actions\Settings\V1\Users;

use App\Models\User;
use App\Services\Actions\Settings\V1\Users\DTO\StoreUserRequestDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StoreUserService
{
    public function handle(StoreUserRequestDTO $storeUserRequestDTO)
    {
        DB::transaction(function () use ($storeUserRequestDTO) {
            $user = User::query()->create([
                'username' => $storeUserRequestDTO->getUsername(),
                'name' => $storeUserRequestDTO->getName(),
                'family' => $storeUserRequestDTO->getFamily(),
                'password' => Hash::make($storeUserRequestDTO->getPassword()),
                'access_request' => [
                    'statuses' => $storeUserRequestDTO->getRequestStatuses(),
                    'types' => $storeUserRequestDTO->getRequestTypes(),
                ],
            ]);

            $user->roles()->sync($storeUserRequestDTO->getRoles());

            $user->projects()->sync($storeUserRequestDTO->getProjects());
        });
    }
}
