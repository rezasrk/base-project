<?php

namespace App\Services\Actions\Settings\V1\Roles;

use App\Models\Permission;

class IndexPermissionService
{
    public function handle(): array
    {
        return Permission::query()
            ->where('parent_id', 0)
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'title' => $permission->name,
                    'children' => $this->getPermissionChildren($permission->id)
                ];
            })->all();
    }

    private function getPermissionChildren(int $permissionParentId)
    {
        return Permission::query()
            ->where('parent_id', $permissionParentId)
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'title' => $permission->name,
                ];
            })->all();
    }
}
