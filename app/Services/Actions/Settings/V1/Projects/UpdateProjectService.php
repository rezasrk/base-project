<?php

namespace App\Services\Actions\Settings\V1\Projects;

use App\Models\Project;

class UpdateProjectService
{
    public function handle(int $projectId, string $title)
    {
        Project::query()->findOrFail($projectId)->update([
            'project_title' => $title,
        ]);
    }
}
