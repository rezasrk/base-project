<?php

namespace App\Services\Actions\Supply\Categories;

use App\Http\Resources\Supply\CategoryResource;
use App\Models\Supply\Category;

class ShowCategoryService
{
    public function handle(int $categoryId): CategoryResource
    {
        $category = Category::query()->findOrFail($categoryId);

        return new CategoryResource($category);
    }
}
