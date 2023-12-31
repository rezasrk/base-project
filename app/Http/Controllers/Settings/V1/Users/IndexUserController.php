<?php

namespace App\Http\Controllers\Settings\V1\Users;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Users\DTO\IndexUserRequestDTO;
use App\Services\Actions\Settings\V1\Users\IndexUserService;
use Illuminate\Http\Request;

/**
 * @group Settings
 *
 * @subGroup User
 *
 *
 */
class IndexUserController extends Controller
{
    /**
     * Users list
     *
     * @queryParam username  Example: Admin
     * @queryParam full_name  Example: Ali Mohammad
     * @queryParam roles  Example: 12,3,34
     *
     * @response{
     *   "status":"success",
     *   "message":"User fetch successfully",
     *   "data" :[
     *         {
     *            "id":4,
     *            "name":"Ali",
     *            "family":"Mohammad",
     *            "username":"admin",
     *            "projects":[
     *                {
     *                   "id":12,
     *                   "title":"Azaran",
     *                   "settings":[]
     *                }
     *            ],
     *           "roles":[
     *               {
     *                  "id":23,
     *                  "name":"writer",
     *                  "permissions":[
     *                      {
     *                         "id":36,
     *                         "name":"write article",
     *                         "parent_id":0
     *                      }
     *                  ]
     *               }
     *           ]
     *         }
     *    ]
     *    "pagination":{
     *       "current_page":1,
     *       "last_page":1,
     *       "per_page":30
     *       "total":1
     *    }
     * }
     */
    public function __invoke(Request $request, IndexUserService $indexUserService)
    {
        $resource = $indexUserService->handle(
            new IndexUserRequestDTO(
                $request->query('username'),
                $request->query('full_name'),
                explode(',', $request->query('roles'))
            )
        );

        return response()->resource(
            __('messages.fetch', ['title' => __('title.user')]),
            $resource,
        );
    }
}
