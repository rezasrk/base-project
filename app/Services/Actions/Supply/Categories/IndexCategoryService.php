<?php

namespace App\Services\Actions\Supply\Categories;

use App\Http\Resources\Supply\CategoryResourceCollection;
use App\Models\Supply\Category;

class IndexCategoryService
{
    public function handle(int $parentId): CategoryResourceCollection
    {
        $categories = Category::query()->where('category_parent_id', $parentId)->paginate(300);

        return new CategoryResourceCollection($categories);
    }
}
