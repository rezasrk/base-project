<?php

namespace App\Services\General\Supply;

use App\Services\General\Supply\Categories\Contracts\SearchCategoryService;
use App\Services\General\Supply\Categories\SearchCategory;
use Illuminate\Support\ServiceProvider;

class SupplyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SearchCategoryService::class, SearchCategory::class);
    }
}
