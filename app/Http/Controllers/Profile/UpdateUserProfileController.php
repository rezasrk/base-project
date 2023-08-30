<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateUserProfileRequest;
use App\Services\Actions\Profile\DTO\UpdateUserProfileRequestDTO;
use App\Services\Actions\Profile\UpdateUserProfileService;

/**
 * @group Profile
 * 
 * @authenticate
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
            uploadedFile: $updateUserProfileRequest->hasFile('user_sign') ? $updateUserProfileRequest->file('user_sign') : null
        ));

        return response()->success(__('messages.update', ['title' => __('title.user_profile')]));
    }
}
