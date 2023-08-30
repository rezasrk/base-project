<?php

namespace App\Services\Actions\Auth;

use App\Http\Resources\ProjectResourceCollection;
use App\Models\User;

class UserProjectsService
{
    public function handle(int $userId): ProjectResourceCollection
    {
        $user = User::query()->find($userId);

        return new ProjectResourceCollection($user->projects()->get());
    }
}
