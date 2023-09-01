<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreRoleRequest;
use App\Services\Actions\Settings\StoreRoleService;

class StoreRoleController extends Controller
{
    public function __invoke(StoreRoleRequest $storeRoleRequest, StoreRoleService $storeRoleService)
    {
        $storeRoleService->handle(
            $storeRoleRequest->input('name'),
            $storeRoleRequest->input('status'),
            $storeRoleRequest->input('permissions')
        );

        return response()->success(__('messages.store', ['title' => __('title.role')]));
    }
}
