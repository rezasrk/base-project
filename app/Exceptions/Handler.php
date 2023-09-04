<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $exception) {
            //
        });

        $this->renderable(function (Throwable $exception, Request $request) {
            return $this->registerException($exception, $request);
        });
    }

    private function registerException(Throwable $exception, Request $request)
    {
        if ($exception instanceof ValidationException) {
            return response()->validationException($exception);
        }

        if ($exception instanceof UnauthorizedException) {
            return response()->error(__('messages.exceptions.authenticate_failed'), JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->error(__('messages.exceptions.unauthenticated'), JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->error(__('messages.exceptions.not_found'), JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
