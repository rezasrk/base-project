<?php

namespace App\Services\Actions\Supply\Categories;

use App\Models\Supply\Category;

class TransferCategoryService
{
    public function handle(int $parentId, int $categoryId)
    {
        Category::query()->findOrFail($categoryId)->update([
            'category_parent_id' => $parentId
        ]);
    }
}
