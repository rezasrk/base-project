<?php

namespace App\Services\General\Support;

trait PaginationInformation
{
    public function pagination(int $currentPage, int $lastPage, int $perPage, int $total): array
    {
        return [
            'pagination' => [
                'current_page' => $currentPage,
                'last_page' => $lastPage,
                'per_page' => $perPage,
                'total' => $total,
            ],
        ];
    }
}
