<?php

namespace App\Services\Actions\Settings\V1\Projects;

use App\Models\Project;

class StoreProjectService
{
    public function handle(string $title)
    {
        Project::query()->create([
            'project_title' => $title,
        ]);
    }
}
