<?php

namespace App\Services\Actions\Settings\V1\Roles;

use App\Http\Resources\Settings\RoleResource;
use App\Models\Role;

class ShowRoleService
{
    public function handle(int $roleId): RoleResource
    {
        return new RoleResource(
            Role::query()->withoutSuperRole()->findOrFail($roleId)
        );
    }
}
