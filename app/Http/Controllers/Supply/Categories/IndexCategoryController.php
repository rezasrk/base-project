<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Services\Actions\Supply\Categories\IndexCategoryService;
use Illuminate\Http\Request;

/**
 * @group Supply
 *
 * @subGroup Category
 *
 * @authenticated
 */
class IndexCategoryController extends Controller
{
    /**
     * Categories list
     *
     * @response{
     *   "status":"success",
     *   "message":"Category fetched successfully",
     *   "data":[
     *      {
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
     *      }
     *    ]
     * }
     */
    public function __invoke(Request $request, IndexCategoryService $indexCategoryService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.category')]),
            $indexCategoryService->handle($request->query('parent_id', 0))
        );
    }
}
