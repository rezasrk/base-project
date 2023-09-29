<?php

namespace App\Http\Controllers\Profile\V1;

use App\Http\Controllers\Controller;
use App\Services\Actions\Profile\V1\DeleteSignatureFileService;
use Illuminate\Http\Request;

/**
 * @group Profile
 *
 *
 */
class DeleteSignatureFileController extends Controller
{
    /**
     * Delete user's signature
     *
     * @response{
     *   "status":"success",
     *   "message":"User's signature deleted successfully"
     * }
     */
    public function __invoke(Request $request, DeleteSignatureFileService $deleteSignatureFileService)
    {
        $deleteSignatureFileService->handle($request->user()->id);

        return response()->success(__('messages.delete', ['title' => __('title.sign')]));
    }
}
