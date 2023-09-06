<?php

namespace App\Http\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Projects\UpdateProjectRequest;
use App\Services\Actions\Settings\V1\Projects\UpdateProjectService;

class UpdateProjectController extends Controller
{
    public function __invoke(int $projectId, UpdateProjectRequest $updateProjectRequest, UpdateProjectService $updateProjectService)
    {
        $updateProjectService->handle($projectId, $updateProjectRequest->input('title'));

        return response()->success(__('messages.update', ['title' => __('title.project')]));
    }
}
