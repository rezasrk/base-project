<?php

namespace App\Http\Controllers\Profile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\V1\UpdateUserProfileRequest;
use App\Services\Actions\Profile\V1\DTO\UpdateUserProfileRequestDTO;
use App\Services\Actions\Profile\V1\UpdateUserProfileService;

/**
 * @group Profile
 *
 *
 */
class UpdateUserProfileController extends Controller
{
    /**
     * Update user's profile
     *
     * @response{
     *   "status":"success",
     *   "message":"User's profile update successfully"
     * }
     */
    public function __invoke(UpdateUserProfileRequest $updateUserProfileRequest, UpdateUserProfileService $updateUserProfileService)
    {
        $updateUserProfileService->handle(new UpdateUserProfileRequestDTO(
            userId: $updateUserProfileRequest->user()->id,
            username: $updateUserProfileRequest->input('username'),
            email: $updateUserProfileRequest->input('email'),
            name: $updateUserProfileRequest->input('name'),
            family: $updateUserProfileRequest->input('family'),
        ));

        return response()->success(__('messages.update', ['title' => __('title.user_profile')]));
    }
}
