<?php

namespace App\Services\Actions\Settings\V1\Users;

use App\Http\Resources\Settings\UserResource;
use App\Models\User;

class ShowUserService
{
    public function handle(int $userId)
    {
        $user = User::query()->withoutSuperUser()->findOrFail($userId);

        return new UserResource($user);
    }
}
