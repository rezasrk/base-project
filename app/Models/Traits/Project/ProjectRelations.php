<?php

namespace App\Models\Traits\Project;

use App\Models\User;

trait ProjectRelations
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects', 'project_id', 'user_id');
    }
}
