<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supply\Categories\StoreCategoryRequest;
use App\Services\Actions\Supply\Categories\StoreCategoryService;
use App\Services\Actions\Supply\DTO\Categories\StoreCategoryRequestDTO;

/**
 * @group Supply
 *
 * @subGroup Category
 *
 *
 */
class StoreCategoryController extends Controller
{
    /**
     * Categories store
     *
     * @response{
     *   "status":"success",
     *   "message":"Category store successfully"
     * }
     */
    public function __invoke(StoreCategoryRequest $storeCategoryRequest, StoreCategoryService $storeCategoryService)
    {
        $storeCategoryService->handle(
            new StoreCategoryRequestDTO(
                code: $storeCategoryRequest->input('code'),
                title: $storeCategoryRequest->input('title'),
                parentId: $storeCategoryRequest->input('parent_id'),
                discipline: $storeCategoryRequest->input('discipline'),
                categoryUnit: $storeCategoryRequest->input('unit'),
                isMainName: $storeCategoryRequest->input('is_main_name') ? true : false
            )
        );

        return response()->success(__('messages.store', ['title' => __('title.category')]));
    }
}
