<?php

use App\Http\Controllers\Settings\V1\Roles\IndexPermissionController;
use App\Http\Controllers\Settings\V1\Roles\IndexRoleController;
use App\Http\Controllers\Settings\V1\Roles\ShowRoleController;
use App\Http\Controllers\Settings\V1\Roles\StoreRoleController;
use App\Http\Controllers\Settings\V1\Roles\UpdateRoleController;
use Illuminate\Support\Facades\Route;

Route::post('roles', StoreRoleController::class)->name('roles.store');
Route::get('roles', IndexRoleController::class)->name('roles.index');
Route::get('{id}/roles', ShowRoleController::class)->name('roles.show');
Route::put('{id}/roles', UpdateRoleController::class)->name('roles.update');
Route::get('permissions', IndexPermissionController::class)->name('permission.index');
