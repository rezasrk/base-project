<?php

namespace App\Http\Controllers\Settings\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Roles\UpdateRoleRequest;
use App\Services\Actions\Settings\Roles\UpdateRoleService;

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
