<?php

namespace App\Http\Controllers\Settings\Roles;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\Roles\ShowRoleService;

/**
 * @group Settings
 *
 * @authenticated
 */
class ShowRoleController extends Controller
{
    /**
     * List roles
     *
     * @response{
     *   "status":"success",
     *   "message":"Role fetch successfully",
     *   "data" : {
     *           "id":4,
     *           "name":"writer",
     *           "permissions":[
     *                {
     *                   "id":12,
     *                   "name":"write",
     *                   "parent_id":0
     *                },
     *                {
     *                   "id":13,
     *                   "name":"write article",
     *                   "parent_id":12
     *                }
     *           ]
     *        }
     * }
     */
    public function __invoke(int $id, ShowRoleService $showRoleService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.role')]),
            $showRoleService->handle($id)
        );
    }
}
