<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SelectProjectRequest;
use App\Services\Actions\Auth\DTO\SelectProjectRequestDTO;
use App\Services\Actions\Auth\SelectProjectService;

/**
 * @group Auth
 *
 *
 */
class SelectProjectController extends Controller
{
    /**
     * Select project
     *
     * @response{
     *   "status":"success",
     *   "message":"User access to this project"
     * }
     */
    public function __invoke(SelectProjectRequest $selectProjectRequest, SelectProjectService $selectProjectService)
    {
        $selectProjectService->handle(
            new SelectProjectRequestDTO(
                $selectProjectRequest->user()->id,
                $selectProjectRequest->input('project_id'),
            )
        );

        return response()->success(__('messages.select-project'));
    }
}
