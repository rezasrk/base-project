<?php

namespace App\Models\Traits\Roles;

trait RoleScope
{
    public function scopeWithoutSuperRole($query)
    {
        $query->where('id', '<>', 1);
    }
}
