<?php

namespace App\Services\General\Supply\Categories;

use App\Services\General\Supply\Categories\Contracts\SearchCategoryService;
use App\Services\General\Supply\Categories\DTO\CategoryTitlesDTO;
use Illuminate\Support\Facades\DB;

class SearchCategory implements SearchCategoryService
{
    public function byTitle(string $categoryTitle): CategoryTitlesDTO
    {
        $categories = DB::table('categories')
            ->selectRaw('
                id,complete_category_title(id) as full_title,
                category_title,
                code
            ')->whereRaw('complete_category_title(id) like ?', ["%" . $categoryTitle . "%"])
            ->paginate(70);

        return new CategoryTitlesDTO($categories);
    }
}
