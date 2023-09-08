<?php

namespace App\Http\Controllers\Settings\V1\Users;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Users\ShowUserService;

/**
 * @group Settings
 *
 * @authenticated
 */
class ShowUserController extends Controller
{
    /**
     * Show user
     * 
     * @urlParam id Example: 45
     *
     * @response{
     *   "status":"success",
     *   "message":"User fetch successfully",
     *   "data" : {
     *           "id":4,
     *           "name":"Ali",
     *           "family":"Mohammad",
     *           "username":"admin",
     *           "projects":[
     *               {
     *                  "id":12,
     *                  "title":"Azaran",
     *                  "settings":[]
     *               }
     *           ],
     *          "roles":[
     *              {
     *                 "id":23,
     *                 "name":"writer",
     *                 "permissions":[
     *                     {
     *                        "id":36,
     *                        "name":"write article",
     *                        "parent_id":0
     *                     }
     *                 ]
     *              }
     *          ]
     *        }
     * }
     */
    public function __invoke(int $userId, ShowUserService $showUserService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.user')]),
            $showUserService->handle($userId),
        );
    }
}
