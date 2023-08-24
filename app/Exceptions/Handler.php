<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
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
            return response()->unauthenticatedException();
        }
    }
}
