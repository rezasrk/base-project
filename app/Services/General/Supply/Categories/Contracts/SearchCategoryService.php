<?php

namespace App\Services\General\Supply\Categories\Contracts;

use App\Services\General\Supply\Categories\DTO\CategoryTitlesDTO;

interface SearchCategoryService
{
    public function byTitle(string $categoryTitle): CategoryTitlesDTO;
}
