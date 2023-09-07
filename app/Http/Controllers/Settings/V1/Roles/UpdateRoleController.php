<?php

namespace App\Http\Controllers\Settings\V1\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Roles\UpdateRoleRequest;
use App\Services\Actions\Settings\V1\Roles\UpdateRoleService;

/**
 * @group Settings
 *
 * @authenticated
 */
class UpdateRoleController extends Controller
{
    /**
     * Update roles
     * 
     * @urlParam id Example: 57
     *
     * @response{
     *   "status":"success",
     *   "message":"Role update successfully"
     * }
     */
    public function __invoke(int $roleId, UpdateRoleRequest $updateRoleRequest, UpdateRoleService $updateRoleService)
    {
        $updateRoleService->handle(
            $roleId,
            $updateRoleRequest->input('name'),
            $updateRoleRequest->input('status'),
            $updateRoleRequest->input('permissions')
        );

        return response()->success(__('messages.update', ['title' => __('title.role')]));
    }
}
