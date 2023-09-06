<?php

namespace App\Http\Controllers\Settings\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Roles\StoreRoleRequest;
use App\Services\Actions\Settings\Roles\StoreRoleService;

/**
 * @group Settings
 *
 * @authenticated
 */
class StoreRoleController extends Controller
{
    /**
     * Store roles
     *
     * @response{
     *   "status":"success",
     *   "message":"Role store successfully"
     * }
     */
    public function __invoke(StoreRoleRequest $storeRoleRequest, StoreRoleService $storeRoleService)
    {
        $storeRoleService->handle(
            $storeRoleRequest->input('name'),
            $storeRoleRequest->input('status'),
            $storeRoleRequest->input('permissions')
        );

        return response()->success(__('messages.store', ['title' => __('title.role')]));
    }
}
