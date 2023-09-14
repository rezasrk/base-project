<?php

namespace App\Services\Actions\Supply\DTO\Categories;

class StoreCategoryRequestDTO
{
    public function __construct(
        private string $code,
        private string $title,
        private int $parentId,
        private int $discipline,
        private int $categoryUnit,
        private bool $isMainName
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function getDiscipline(): int
    {
        return $this->discipline;
    }

    public function getCategoryUnit(): int
    {
        return $this->categoryUnit;
    }

    public function isMainName(): bool
    {
        return $this->isMainName;
    }
}
