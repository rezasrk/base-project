<?php

namespace App\Models\Traits\User;

use App\Models\Project;

trait UserRelations
{
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'user_projects', 'user_id', 'project_id');
    }
}
