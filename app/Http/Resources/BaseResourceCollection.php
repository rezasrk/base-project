<?php

namespace App\Http\Resources;

use App\Services\General\Support\PaginationInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    use PaginationInformation;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public function paginationInformation($request, $paginated, $default)
    {
        return $this->pagination(
            $default['meta']['current_page'],
            $default['meta']['last_page'],
            $default['meta']['per_page'],
            $default['meta']['total']
        );
    }
}
