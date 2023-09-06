<?php

namespace App\Models;

use App\Models\Traits\Project\ProjectRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use ProjectRelations;

    protected $casts = [
        'settings' => 'array',
    ];

    protected $guarded = [];
}
