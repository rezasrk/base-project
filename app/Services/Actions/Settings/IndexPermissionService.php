<?php

namespace App\Services\Actions\Settings;

use App\Http\Resources\Settings\PermissionResourceCollection;
use App\Models\Permission;

class IndexPermissionService
{
    public function handle(): PermissionResourceCollection
    {
        $permissions = Permission::query()->get();

        return new PermissionResourceCollection($permissions);
    }
}
