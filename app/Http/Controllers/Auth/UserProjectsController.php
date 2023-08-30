<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Actions\Auth\UserProjectsService;
use Illuminate\Http\Request;

/**
 * @group Auth
 *
 * @authenticate
 */
class UserProjectsController extends Controller
{
    /**
     * User's projects
     *
     * @response{
     *   "status":"success",
     *   "message":"User's projects fetch correctly",
     *   "data":[
     *       {
     *          "id":1,
     *          "title":"first project",
     *       }
     *    ]
     * }
     */
    public function __invoke(Request $request, UserProjectsService $userProjectsService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.user_projects')]),
            $userProjectsService->handle($request->user()->id),
        );
    }
}
