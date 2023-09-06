<?php

namespace App\Services\Actions\Settings\V1\Roles;

use App\Models\Role;

class StoreRoleService
{
    public function handle(string $name, int $status, array $permissions)
    {
        $role = Role::query()->create([
            'name' => $name,
            'guard_name' => 'sanctum',
            'status' => $status,
        ]);

        $role->permissions()->sync($permissions);
    }
}
