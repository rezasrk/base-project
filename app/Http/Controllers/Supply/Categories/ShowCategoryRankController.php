<?php

namespace App\Http\Controllers\Supply\Categories;

use App\Http\Controllers\Controller;
use App\Services\Actions\Supply\Categories\ShowCategoryRankService;

/**
 * @group Supply
 *
 * @subGroup Category
 *
 *
 */
class ShowCategoryRankController extends Controller
{
    /**
     * Category rank
     *
     * @response{
     *   "status":"success",
     *   "message":"Category fetched successfully",
     *   "data":{
     *      1,
     *      234,
     *      4256
     *    }
     * }
     */
    public function __invoke($id, ShowCategoryRankService $showCategoryRankService)
    {
        return response()->success(
            __('messages.fetch', ['title' => __('title.category')]),
            $showCategoryRankService->handle($id)
        );
    }
}
