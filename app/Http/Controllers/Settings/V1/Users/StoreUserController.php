<?php

namespace App\Http\Controllers\Settings\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Users\StoreUserRequest;
use App\Services\Actions\Settings\V1\Users\DTO\StoreUserRequestDTO;
use App\Services\Actions\Settings\V1\Users\StoreUserService;

/**
 * @group Settings
 * @subGroup User
 *
 * @authenticated
 */
class StoreUserController extends Controller
{
    /**
     * Users store
     *
     * @response{
     *   "status":"success",
     *   "message":"User store successfully"
     * }
     */
    public function __invoke(StoreUserRequest $storeUserRequest, StoreUserService $storeUserService)
    {
        $storeUserService->handle(
            new StoreUserRequestDTO(
                username: $storeUserRequest->input('username'),
                name: $storeUserRequest->input('name'),
                family: $storeUserRequest->input('family'),
                projects: $storeUserRequest->input('projects'),
                requestStatuses: $storeUserRequest->input('request_statuses'),
                requestTypes: $storeUserRequest->input('request_types'),
                roles: $storeUserRequest->input('roles'),
                password: $storeUserRequest->input('password')
            )
        );

        return response()->success(__('messages.store', ['title' => __('title.user')]));
    }
}
