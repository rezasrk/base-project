<?php

namespace App\Http\Controllers\Settings\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Projects\StoreProjectRequest;
use App\Services\Actions\Settings\Projects\StoreProjectService;

/** 
 * @group Settings
 * 
 * @authenticated
 */
class StoreProjectController extends Controller
{
    /**
     * Store projects
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
