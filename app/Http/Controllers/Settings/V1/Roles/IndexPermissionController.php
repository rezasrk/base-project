<?php

namespace App\Http\Controllers\Settings\V1\Roles;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Roles\IndexPermissionService;

/**
 * @group Settings
 *
 * @subGroup Role
 *
 *
 */
class IndexPermissionController extends Controller
{
    /**
     * Permissions list
     *
     * @response{
     *   "status":"success",
     *   "message":"Permission fetch successfully",
     *   "data":[
     *      {
     *         "id":1,
     *         "name":"Supply menu",
     *         "children":[
     *             {
     *                "id":2,
     *                "name":"Store users",
     *             } 
     *         ]
     *      }
     *   ]
     * }
     */
    public function __invoke(IndexPermissionService $indexPermissionService)
    {
        return response()->success(
            __('messages.fetch', ['title' => __('title.permission')]),
            $indexPermissionService->handle(),
        );
    }
}
