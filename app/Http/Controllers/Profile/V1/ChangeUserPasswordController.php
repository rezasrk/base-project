<?php

namespace App\Http\Controllers\Profile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\V1\ChangeUserPasswordRequest;
use App\Services\Actions\Profile\V1\ChangeUserPasswordService;
use App\Services\Actions\Profile\V1\DTO\ChangeUserPasswordRequestDTO;

/**
 * @group Profile
 *
 *
 */
class ChangeUserPasswordController extends Controller
{
    /**
     * Change user's password
     *
     * @response{
     *   "status":"success",
     *   "message":"User's password update successfully"
     * }
     */
    public function __invoke(ChangeUserPasswordRequest $changeUserPasswordRequest, ChangeUserPasswordService $changeUserPasswordService)
    {
        $changeUserPasswordService->handle(
            new ChangeUserPasswordRequestDTO(
                $changeUserPasswordRequest->user()->id,
                $changeUserPasswordRequest->input('old_password'),
                $changeUserPasswordRequest->input('new_password')
            )
        );

        return response()->success(__('messages.update', ['title' => __('title.user_password')]));
    }
}
