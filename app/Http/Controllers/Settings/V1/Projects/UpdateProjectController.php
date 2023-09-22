<?php

namespace App\Http\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Projects\UpdateProjectRequest;
use App\Services\Actions\Settings\V1\Projects\UpdateProjectService;

/**
 * @group Settings
 *
 * @subGroup Project
 *
 * @authenticated
 */
class UpdateProjectController extends Controller
{
    /**
     * Projects update
     *
     * @urlParam id Example: 63
     *
     * @response{
     *   "status":"success",
     *   "message":"Project update successfully"
     * }
     */
    public function __invoke(int $projectId, UpdateProjectRequest $updateProjectRequest, UpdateProjectService $updateProjectService)
    {
        $updateProjectService->handle($projectId, $updateProjectRequest->input('title'));

        return response()->success(__('messages.update', ['title' => __('title.project')]));
    }
}
