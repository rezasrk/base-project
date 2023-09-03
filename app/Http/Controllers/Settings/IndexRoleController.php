<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\Actions\Settings\IndexRoleService;

class IndexRoleController extends Controller
{
    public function __invoke(IndexRoleService $indexRoleService)
    {
        return response()->resource(
            __('messages.fetch', ['title' => __('title.role')]),
            $indexRoleService->handle()
        );
    }
}
