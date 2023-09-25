<?php

namespace App\Services\General\Supply\Categories\DTO;

use App\Services\General\Support\PaginationInformation;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryTitlesDTO
{
    use PaginationInformation;

    public function __construct(private LengthAwarePaginator $categories)
    {
    }

    public function getCategories(): array
    {
        return  $this->categories->map(function ($category) {
            return [
                'id' => $category->id,
                'code' => $category->code,
                'full_title' => $category->full_title,
                'title' => $category->category_title,
            ];
        })->toArray();
    }

    public function getPaginationInformation(): array
    {
        return $this->pagination(
            $this->categories->currentPage(),
            $this->categories->lastPage(),
            $this->categories->perPage(),
            $this->categories->total()
        );
    }
}
