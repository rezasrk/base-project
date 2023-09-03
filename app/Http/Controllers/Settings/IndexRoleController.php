<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\IndexRoleService;

/** 
 * @group Settings
 * 
 * @authenticated
 */
class IndexRoleController extends Controller
{
    /**
     * List roles
     * 
     * @response{
     *   "status":"success",
     *   "message":"Role fetch successfully",
     *   "data" : [
     *        {
     *           "id":4,
     *           "name":"writer"
     *        }
     *    ],
     *    "pagination_information":{
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
