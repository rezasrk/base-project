<?php

namespace App\Services\Actions\Auth\Exceptions;

use App\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;

final class SelectProjectException extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            message: __('messages.exceptions.select_project'),
            code: JsonResponse::HTTP_FORBIDDEN
        );
    }

    public function render()
    {
        return response()->error($this->getMessage(), $this->getCode());
    }
}
