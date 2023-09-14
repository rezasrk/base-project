<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Services\Actions\Supply\Categories\IndexCategoryService;
use Illuminate\Http\Request;

/**
 * @group Supply
 *
 * @authenticated
 */
class IndexCategoryController extends Controller
{
    public function __invoke(Request $request, IndexCategoryService $indexCategoryService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.category')]),
            $indexCategoryService->handle($request->query('parent_id', 0))
        );
    }
}
