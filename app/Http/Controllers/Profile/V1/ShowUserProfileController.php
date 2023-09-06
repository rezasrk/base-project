<?php

namespace App\Http\Controllers\Profile\V1;

use App\Http\Controllers\Controller;
use App\Services\Actions\Profile\V1\DTO\ShowUserProfileRequestDTO;
use App\Services\Actions\Profile\V1\ShowUserProfileService;
use Illuminate\Http\Request;

/**
 * @group Profile
 *
 * @authenticated
 */
class ShowUserProfileController extends Controller
{
    /**
     * Show user's profile
     *
     * @response{
     *   "status":"success",
     *   "message":"User's profile update successfully",
     *   "data":{
     *       "id" : 1,
     *       "username" : "admin",
     *       "email" : "admin@gmail.com",
     *       "name" : "ALI",
     *       "family" : "Mohammad",
     *       "sign" : "/path/to/sing.jpeg"
     *    }
     * }
     */
    public function __invoke(Request $request, ShowUserProfileService $showUserProfileService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.user_profile')]),
            $showUserProfileService->handle(
                new ShowUserProfileRequestDTO(
                    userId: $request->user()->id
                )
            )
        );
    }
}
