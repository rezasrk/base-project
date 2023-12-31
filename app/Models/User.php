<?php

namespace App\Models;

use App\Models\Traits\User\UserRelations;
use App\Models\Traits\User\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use UserRelations;
    use UserScope;

    protected $guarded = [];

    protected $casts = [
        'access_request' => 'array',
    ];
}
