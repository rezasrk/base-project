<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supply\Categories\TransferCategoryRequest;
use App\Services\Actions\Supply\Categories\TransferCategoryService;

/**
 * @group Supply
 * @subGroup Category
 *
 * @authenticated
 */
class TransferCategoryController extends Controller
{
    /**
     * Categories transfer
     *
     * @response{
     *   "status":"success",
     *   "message":"Category update successfully"
     * }
     */
    public function __invoke(TransferCategoryRequest $transferCategoryRequest, TransferCategoryService $transferCategoryService)
    {
        $transferCategoryService->handle(
            $transferCategoryRequest->input('category_parent_id'),
            $transferCategoryRequest->input('category_id')
        );

        return response()->success(__('messages.update', ['title' => __('title.category')]));
    }
}
