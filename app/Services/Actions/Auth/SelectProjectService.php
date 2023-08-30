<?php

namespace App\Services\Actions\Auth;

use App\Models\User;
use App\Services\Actions\Auth\DTO\SelectProjectRequestDTO;
use App\Services\Actions\Auth\Exceptions\SelectProjectException;

class SelectProjectService
{
    public function handle(SelectProjectRequestDTO $selectProjectRequestDTO)
    {
        $user = User::query()->findOrFail($selectProjectRequestDTO->getUserId());

        $project = $user->projects()->where('id', $selectProjectRequestDTO->getProjectId())->first();

        if (is_null($project)) {
            throw new SelectProjectException;
        }
    }
}
