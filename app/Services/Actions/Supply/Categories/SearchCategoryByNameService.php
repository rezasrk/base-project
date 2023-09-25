<?php

namespace App\Services\Actions\Supply\Categories;

use App\Services\General\Supply\Categories\Contracts\SearchCategoryService;
use App\Services\General\Supply\Categories\DTO\CategoryTitlesDTO;

class SearchCategoryByNameService
{
    public function __construct(private SearchCategoryService $searchCategoryService)
    {
    }

    public function handle(string $categoryTitle): CategoryTitlesDTO
    {
        return $this->searchCategoryService->byTitle($categoryTitle);
    }
}
