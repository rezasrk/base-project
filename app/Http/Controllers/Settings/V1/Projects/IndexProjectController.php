<?php

namespace App\Http\Controllers\Settings\V1\Projects;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Projects\IndexProjectService;

/**
 * @group Settings
 * @subGroup Project
 *
 * @authenticated
 */
class IndexProjectController extends Controller
{
    /**
     * Project lists
     *
     * @response{
     *   "status":"success",
     *   "message":"Project fetch successfully",
     *   "data":[
     *      {
     *        "id" :13,
     *        "title":"Project title",
     *        "settings":{
     *           "supply":{
     *               "pre_request_status":346,
     *               "status":{
     *                   "first_status":{
     *                      "id":324,
     *                      "value":"Sent"
     *                   },
     *                   "last_status":{
     *                      "id":329,
     *                      "value":"Supply"
     *                   },
     *                   "between_statuses":[
     *                       {
     *                          "id":432,
     *                          "value":"Accept"
     *                       }
     *                   ]
     *               }
     *           }
     *        }
     *      }
     *  ]
     * }
     */
    public function __invoke(IndexProjectService $indexProjectService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.project')]),
            $indexProjectService->handle()
        );
    }
}
