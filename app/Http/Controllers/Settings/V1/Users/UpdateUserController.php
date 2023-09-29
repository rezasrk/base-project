<?php

namespace App\Http\Controllers\Settings\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Users\UpdateUserRequest;
use App\Services\Actions\Settings\V1\Users\DTO\UpdateUserRequestDTO;
use App\Services\Actions\Settings\V1\Users\UpdateUserService;

/**
 * @group Settings
 *
 * @subGroup User
 *
 *
 */
class UpdateUserController extends Controller
{
    /**
     * Users update
     *
     * @response{
     *   "status":"success",
     *   "message":"User update successfully"
     * }
     */
    public function __invoke(int $id, UpdateUserRequest $updateUserRequest, UpdateUserService $updateUserService)
    {
        $updateUserService->handle(
            new UpdateUserRequestDTO(
                userId: $id,
                username: $updateUserRequest->input('username'),
                name: $updateUserRequest->input('name'),
                family: $updateUserRequest->input('family'),
                projects: $updateUserRequest->input('projects'),
                requestStatuses: $updateUserRequest->input('request_statuses'),
                requestTypes: $updateUserRequest->input('request_types'),
                roles: $updateUserRequest->input('roles'),
                password: $updateUserRequest->input('password')
            )
        );

        return response()->success(__('messages.update', ['title' => __('title.user')]));
    }
}
