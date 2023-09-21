<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supply\Categories\SortCategoryRequest;
use App\Services\Actions\Supply\Categories\SortCategoryService;

/**
 * @group Supply
 *
 * @authenticated
 */
class SortCategoryController extends Controller
{
    /**
     * Categories sort
     *
     * @response{
     *   "status":"success",
     *   "message":"Category update successfully"
     * }
     */
    public function __invoke(SortCategoryRequest $sortCategoryRequest, SortCategoryService $sortCategoryService)
    {
        $sortCategoryService->handle(
            $sortCategoryRequest->input('data')
        );

        return response()->success(__('messages.update', ['title' => __('title.category')]));
    }
}
