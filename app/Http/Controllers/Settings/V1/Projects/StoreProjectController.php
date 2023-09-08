<?php

namespace App\Http\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Projects\StoreProjectRequest;
use App\Services\Actions\Settings\V1\Projects\StoreProjectService;

/**
 * @group Settings
 *
 * @authenticated
 */
class StoreProjectController extends Controller
{
    /**
     * Projects store
     *
     * @response{
     *   "status":"success",
     *   "message":"Project store successfully"
     * }
     */
    public function __invoke(StoreProjectRequest $storeProjectRequest, StoreProjectService $storeProjectService)
    {
        $storeProjectService->handle(
            $storeProjectRequest->input('title'),
        );

        return response()->success(__('messages.store', ['title' => __('title.project')]));
    }
}
