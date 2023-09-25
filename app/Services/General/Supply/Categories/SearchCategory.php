<?php

namespace App\Services\General\Supply\Categories;

use App\Services\General\Supply\Categories\Contracts\SearchCategoryService;
use App\Services\General\Supply\Categories\DTO\CategoryTitlesDTO;
use Illuminate\Support\Facades\DB;

/**
 * @group Supply
 *
 * @subGroup Category
 *
 * @authenticated
 */
class SearchCategory implements SearchCategoryService
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
     *       "code":"05",
     *       "title":"Category title",
     *       "full_title":"First Category- Second Category",
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
    public function byTitle(string $categoryTitle): CategoryTitlesDTO
    {
        $categories = DB::table('categories')
            ->selectRaw('
                id,complete_category_title(id) as full_title,
                category_title,
                code
            ')
            ->orderByDesc('id')
            ->whereRaw('complete_category_title(id) like ?', ["%" . $categoryTitle . "%"])
            ->paginate(70);

        return new CategoryTitlesDTO($categories);
    }
}
