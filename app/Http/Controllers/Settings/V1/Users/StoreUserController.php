<?php

namespace App\Http\Controllers\Settings\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\V1\Users\StoreUserRequest;
use App\Services\Actions\Settings\V1\Users\DTO\StoreUserRequestDTO;
use App\Services\Actions\Settings\V1\Users\StoreUserService;

/**
 * @group Settings
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
                $storeUserRequest->input('username'),
                $storeUserRequest->input('name'),
                $storeUserRequest->input('family'),
                $storeUserRequest->input('password'),
                $storeUserRequest->input('projects'),
                $storeUserRequest->input('request_statuses'),
                $storeUserRequest->input('request_types'),
                $storeUserRequest->input('roles')
            )
        );

        return response()->success(__('messages.store', ['title' => __('title.user')]));
    }
}
