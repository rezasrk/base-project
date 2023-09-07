<?php

namespace App\Services\Actions\Settings\V1\Projects;

use App\Http\Resources\Settings\ProjectResource;
use App\Models\Project;

class ShowProjectService
{
    public function handle(int $projectId): ProjectResource
    {
        $project = Project::query()->findOrFail($projectId);

        return new ProjectResource($project);
    }
}
