<?php

namespace App\Services\Actions\Settings\Roles;

use App\Models\Role;

class UpdateRoleService
{
    public function handle(int $roleId, string $name, int $status, array $permissions)
    {
        $role = Role::query()->withOutSuperRole()->findOrFail($roleId);

        $role->update([
            'name' => $name,
            'guard_name' => 'sanctum',
            'status' => $status
        ]);

        $role->permissions()->sync($permissions);
    }
}
