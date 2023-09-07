<?php

namespace App\Services\Actions\Settings\V1\Projects;

use App\Http\Resources\Settings\ProjectResourceCollection;
use App\Models\Project;

class IndexProjectService
{
    public function handle(): ProjectResourceCollection
    {
        return new ProjectResourceCollection(Project::query()->get());
    }
}
