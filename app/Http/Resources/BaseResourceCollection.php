<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public function paginationInformation($request, $paginated, $default)
    {
        return [
            'pagination_information' => [
                'current_page' => $default['meta']['current_page'],
                'last_page' => $default['meta']['last_page'],
                'per_page' => $default['meta']['per_page'],
                'total' => $default['meta']['total'],
            ],
        ];
    }
}
