<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Services\Actions\Supply\Categories\SearchCategoryByNameService;
use Illuminate\Http\Request;

class SearchCategoryByNameController extends Controller
{
    public function __invoke(Request $request, SearchCategoryByNameService $SearchCategoriesByNameService)
    {
        $result = $SearchCategoriesByNameService->handle($request->query('title'));

        return response()->success(
            __('messages.fetch', ['title' => __('title.category')]),
            $result->getCategories(),
            $result->getPaginationInformation(),
        );
    }
}
