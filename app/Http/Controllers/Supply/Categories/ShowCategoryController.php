<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Services\Actions\Supply\Categories\ShowCategoryService;

/**
 * @group Supply
 *
 * @subGroup Category
 *
 *
 */
class ShowCategoryController extends Controller
{
    /**
     * Category show
     *
     * @response{
     *   "status":"success",
     *   "message":"Category fetched successfully",
     *   "data":{
     *       "id":124,
     *       "title":"Category title",
     *       "code":"05",
     *       "discipline":{
     *           "id":34,
     *           "value":"General"
     *       },
     *       "unit":{
     *           "id":98,
     *           "value":"Kilo Gram"
     *       }
     *    }
     * }
     */
    public function __invoke(int $id, ShowCategoryService $showCategoryService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.category')]),
            $showCategoryService->handle($id)
        );
    }
}
