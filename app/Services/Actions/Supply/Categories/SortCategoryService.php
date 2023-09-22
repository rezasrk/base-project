<?php

namespace App\Services\Actions\Supply\Categories;

use App\Models\Supply\Category;

class SortCategoryService
{
    public function handle(array $sortCategories)
    {
        foreach ($sortCategories as $sortCategory) {
            Category::query()->where('id', $sortCategory['category_id'])
                ->update([
                    'priority' => $sortCategory['priority'],
                ]);
        }
    }
}
