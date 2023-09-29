<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supply\Categories\UpdateCategoryRequest;
use App\Services\Actions\Supply\Categories\UpdateCategoryService;
use App\Services\Actions\Supply\DTO\Categories\UpdateCategoryRequestDTO;

/**
 * @group Supply
 *
 * @subGroup Category
 *
 *
 */
class UpdateCategoryController extends Controller
{
    /**
     * Categories update
     *
     * @response{
     *   "status":"success",
     *   "message":"Category update successfully"
     * }
     */
    public function __invoke(int $categoryId, UpdateCategoryRequest $updateCategoryRequest, UpdateCategoryService $updateCategoryService)
    {
        $updateCategoryService->handle(
            new UpdateCategoryRequestDTO(
                categoryId: $categoryId,
                code: $updateCategoryRequest->input('code'),
                title: $updateCategoryRequest->input('title'),
                parentId: $updateCategoryRequest->input('parent_id'),
                discipline: $updateCategoryRequest->input('discipline'),
                categoryUnit: $updateCategoryRequest->input('unit'),
                isMainName: $updateCategoryRequest->input('is_main_name') ? true : false

            )
        );

        return response()->success(__('messages.update', ['title' => __('title.category')]));
    }
}
