<?php

namespace App\Http\Controllers\Settings\V1\Roles;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\V1\Roles\IndexPermissionService;

/**
 * @group Settings
 *
 * @authenticated
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
     *         "name":"Edit Article",
     *         "parent_id":0
     *      }
     *   ]
     * }
     */
    public function __invoke(IndexPermissionService $indexPermissionService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.permission')]),
            $indexPermissionService->handle(),
        );
    }
}
