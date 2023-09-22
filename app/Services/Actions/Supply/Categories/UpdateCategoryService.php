<?php

namespace App\Services\Actions\Supply\Categories;

use App\Models\Supply\Category;
use App\Services\Actions\Supply\DTO\Categories\UpdateCategoryRequestDTO;

class UpdateCategoryService
{
    public function handle(UpdateCategoryRequestDTO $updateCategoryRequestDTO): void
    {
        Category::query()
            ->findOrFail($updateCategoryRequestDTO->getCategoryId())
            ->update([
                'code' => $updateCategoryRequestDTO->getCode(),
                'category_title' => $updateCategoryRequestDTO->getTitle(),
                'category_parent_id' => $updateCategoryRequestDTO->getParentId(),
                'discipline_id' => $updateCategoryRequestDTO->getDiscipline(),
                'unit_id' => $updateCategoryRequestDTO->getCategoryUnit(),
                'is_product' => $updateCategoryRequestDTO->isMainName(),
            ]);
    }
}
