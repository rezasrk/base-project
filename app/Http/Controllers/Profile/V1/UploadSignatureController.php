<?php

namespace App\Http\Controllers\Profile\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\V1\UploadSignatureRequest;
use App\Services\Actions\Profile\V1\UploadSignatureService;

/**
 * @group Profile
 *
 * @authenticated
 */
class UploadSignatureController extends Controller
{
    /**
     * Upload user's signature
     *
     * @response{
     *   "status":"success",
     *   "message":"User's uploaded successfully",
     *   "data":{
     *      "signature_path":"https://127.0.0.1:8000/signature/dkjqeplanbvrywbsskweutjhbsg.png"
     *    }
     * }
     */
    public function __invoke(UploadSignatureRequest $uploadSignatureRequest, UploadSignatureService $uploadSIgnatureService)
    {
        $path = $uploadSIgnatureService->handel(
            $uploadSignatureRequest->user()->id,
            $uploadSignatureRequest->file('signature_file')
        );

        return response()->success(
            __('messages.upload', ['title' => __('title.signature')]),
            [
                'signature_path' => $path,
            ]
        );
    }
}
