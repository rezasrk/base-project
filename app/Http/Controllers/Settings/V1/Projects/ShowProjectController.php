<?php

namespace App\Http\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Projects\ShowProjectService;

/**
 * @group Settings
 *
 * @authenticated
 */
class ShowProjectController extends Controller
{
    /**
     * Show project
     * 
     * @urlParam id Example: 987
     *
     * @response{
     *   "status":"success",
     *   "message":"Project fetch successfully",
     *   "data":{
     *      "id" :13,
     *      "title":"Project title",
     *      "settings":{
     *         "supply":{
     *             "pre_request_status":346,
     *             "status":{
     *                 "first_status":{
     *                    "id":324,
     *                    "value":"Sent"
     *                 },
     *                 "last_status":{
     *                    "id":329,
     *                    "value":"Supply"
     *                 },
     *                 "between_statuses":[
     *                     {
     *                        "id":432,
     *                        "value":"Accept"
     *                     }
     *                 ]
     *             }
     *         }
     *      }
     *   }
     * }
     */
    public function __invoke(int $projectId, ShowProjectService $showProjectService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.project')]),
            $showProjectService->handle($projectId)
        );
    }
}
