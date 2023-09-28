<?php

namespace App\Services\Actions\Supply\Categories;

use App\Models\Supply\Category;

class ShowCategoryRankService
{
    private static $limit = 10;

    private array $categoryRank = [];

    public function handle(int $categoryId): array
    {
        if (self::$limit == 0) {
            return $this->categoryRank;
        }

        return $this->findCategoryParent($categoryId);
    }

    private function findCategoryParent(int $categoryId): array
    {
        $category = Category::query()->findOrFail($categoryId);

        $this->categoryRank[] = $categoryId;

        if ($category->category_parent_id == 0) {
            return $this->categoryRank;
        }

        self::$limit--;

        return $this->findCategoryParent($category->category_parent_id);
    }
}
