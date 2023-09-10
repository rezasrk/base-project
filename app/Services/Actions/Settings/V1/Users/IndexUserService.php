<?php

namespace App\Services\Actions\Settings\V1\Users;

use App\Http\Resources\Settings\UserResourceCollection;
use App\Models\User;
use App\Services\Actions\Settings\V1\Users\DTO\IndexUserRequestDTO;

class IndexUserService
{
    public function handle(IndexUserRequestDTO $indexUserRequestDTO)
    {
        $users = User::query()
            ->when($indexUserRequestDTO->getUsername(), function ($query) use ($indexUserRequestDTO) {
                $query->where('username', $indexUserRequestDTO->getUsername());
            })
            ->when($indexUserRequestDTO->getFullName(), function ($query) use ($indexUserRequestDTO) {
                $query->whereRaw("concat_ws(' ',name,family) like ?", ['%' . $indexUserRequestDTO->getFullName() . '%']);
            })
            ->when($indexUserRequestDTO->getRoles(), function ($query) use ($indexUserRequestDTO) {
                $query->whereHas('roles', function ($query) use ($indexUserRequestDTO) {
                    $query->whereIn('id', $indexUserRequestDTO->getRoles());
                });
            })
            ->withoutSuperUser()
            ->paginate(30);

        return new UserResourceCollection($users);
    }
}
