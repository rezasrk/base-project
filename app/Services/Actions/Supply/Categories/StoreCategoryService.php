<?php

namespace App\Services\Actions\Supply\Categories;

use App\Models\Supply\Category;
use App\Services\Actions\Supply\DTO\Categories\StoreCategoryRequestDTO;

class StoreCategoryService
{
    public function handle(StoreCategoryRequestDTO $storeCategoryRequestDTO): void
    {
        Category::query()->create([
            'code' => $storeCategoryRequestDTO->getCode(),
            'category_title' => $storeCategoryRequestDTO->getTitle(),
            'category_parent_id' => $storeCategoryRequestDTO->getParentId(),
            'discipline_id' => $storeCategoryRequestDTO->getDiscipline(),
            'unit_id' => $storeCategoryRequestDTO->getCategoryUnit(),
            'is_product' => $storeCategoryRequestDTO->isMainName()
        ]);
    }
}
