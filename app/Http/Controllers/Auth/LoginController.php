<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Actions\Auth\DTO\LoginRequestDTO;
use App\Services\Actions\Auth\LoginService;

/**
 * @group Auth
 */
class LoginController extends Controller
{
    /**
     * Login
     *
     * @response{
     *   "status":"success",
     *   "message":"User login successfully"
     *   "data":{
     *        "token":"1|kdughDHGFitfqpmnbdh43E32"
     *    }
     * }
     */
    public function __invoke(LoginRequest $loginRequest, LoginService $loginService)
    {
        $result = $loginService->handle(
            new LoginRequestDTO(
                username: $loginRequest->input('username'),
                password: $loginRequest->input('password')
            )
        );

        return response()->success(__('messages.login_successul'), [
            'token' => $result->getToken(),
        ]);
    }
}
