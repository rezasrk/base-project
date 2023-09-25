<?php

namespace App\Http\Controllers\Settings\V1\Roles;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Roles\IndexRoleService;

/**
 * @group Settings
 *
 * @subGroup Role
 *
 * @authenticated
 */
class IndexRoleController extends Controller
{
    /**
     * Roles list
     *
     * @response{
     *   "status":"success",
     *   "message":"Role fetch successfully",
     *   "data" : [
     *        {
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
     *    ],
     *    "pagination":{
     *       "current_page":1,
     *       "last_page":1,
     *       "per_page":30
     *       "total":1
     *    }
     * }
     */
    public function __invoke(IndexRoleService $indexRoleService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.role')]),
            $indexRoleService->handle()
        );
    }
}
