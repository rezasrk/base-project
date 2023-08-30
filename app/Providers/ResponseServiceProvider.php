<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->successResponse();

        $this->resourceResponse();

        $this->validationExceptionResponse();

        $this->errorResponse();
    }

    private function successResponse()
    {
        Response::macro('success', function (string $message, array $data = []) {
            return response()->json(
                collect([
                    'status' => 'success',
                    'message' => $message,
                ])
                    ->merge(['data' => $data])
                    ->filter()
                    ->all(),
                JsonResponse::HTTP_OK
            );
        });
    }

    private function resourceResponse()
    {
        Response::macro('resource', function (string $message, JsonResource $jsonResource) {
            return $jsonResource->additional([
                'status' => 'success',
                'message' => $message,
            ]);
        });
    }

    private function validationExceptionResponse()
    {
        Response::macro('validationException', function (ValidationException $validationException) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.exceptions.validation'),
                'errors' => $validationException->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        });
    }

    private function errorResponse()
    {
        Response::macro('error', function (string $message, int $httpStatusCode) {
            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], $httpStatusCode);
        });
    }
}
