<?php

namespace App\Services\Actions\Profile\V1;

use App\Http\Resources\Profile\UserProfileResource;
use App\Models\User;
use App\Services\Actions\Profile\V1\DTO\ShowUserProfileRequestDTO;

class ShowUserProfileService
{
    public function handle(ShowUserProfileRequestDTO $showUserProfileRequestDTO)
    {
        return new UserProfileResource(User::query()->findOrFail($showUserProfileRequestDTO->getUserId()));
    }
}
