<?php

namespace App\Http\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Projects\ProjectSettingsRequest;
use App\Services\Actions\Settings\V1\Projects\DTO\ProjectSettingsRequestDTO;
use App\Services\Actions\Settings\V1\Projects\ProjectSettingsService;

/**
 * @group Settings
 *
 * @subGroup Project
 *
 * @authenticated
 */
class ProjectSettingsController extends Controller
{
    /**
     * Project update settings
     *
     * @urlParam id Example: 692
     *
     * @response{
     *   "status":"success",
     *   "message":"Project request update successfully"
     * }
     */
    public function __invoke(int $projectId, ProjectSettingsRequest $projectSettingsRequest, ProjectSettingsService $projectSettingsService)
    {
        $projectSettingsService->handle(
            new ProjectSettingsRequestDTO(
                $projectId,
                $projectSettingsRequest->input('settings')
            )
        );

        return response()->success(__('messages.update', ['title' => __('title.project_settings')]));
    }
}
