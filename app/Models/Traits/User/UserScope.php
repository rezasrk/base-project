<?php

namespace App\Models\Traits\User;

trait UserScope
{
    public function scopeWithoutSuperUser($query)
    {
        $query->where('id', '<>', 1);
    }
}
