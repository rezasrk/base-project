<?php

namespace App\Models;

use App\Models\Traits\Roles\RoleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory;
    use RoleScope;
}
