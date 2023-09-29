<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Services\Actions\Supply\Categories\SearchCategoryByNameService;
use Illuminate\Http\Request;

/**
 * @group Supply
 *
 * @subGroup Category
 */
class SearchCategoryByNameController extends Controller
{
    /**
     * Categories search
     *
     * @response{
     *   "status":"success",
     *   "message":"Category fetched successfully",
     *   "data":[
     *      {
     *       "id":124,
     *       "code":"2487",
     *       "title":"Category title",
     *       "full_title":"first category - second category",
     *      }
     *    ],
     *    "pagination":{
     *       "current_page":1,
     *       "last_page":1,
     *       "per_page":70
     *       "total":1
     *    }
     * }
     */
    public function __invoke(Request $request, SearchCategoryByNameService $SearchCategoriesByNameService)
    {
        $result = $SearchCategoriesByNameService->handle($request->query('title'));

        return response()->success(
            __('messages.fetch', ['title' => __('title.category')]),
            $result->getCategories(),
            $result->getPaginationInformation(),
        );
    }
}
