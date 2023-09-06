<?php

namespace App\Services\Actions\Settings\V1\Roles;

use App\Http\Resources\Settings\RoleResourceCollection;
use App\Models\Role;

class IndexRoleService
{
    public function handle(): RoleResourceCollection
    {
        $roles = Role::query()->withoutSuperRole()->paginate(30);

        return new RoleResourceCollection($roles);
    }
}
