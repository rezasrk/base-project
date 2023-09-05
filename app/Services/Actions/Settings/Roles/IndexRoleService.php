<?php

namespace App\Services\Actions\Settings\Roles;

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
