<?php

use App\Http\Controllers\Settings\Roles\IndexPermissionController;
use App\Http\Controllers\Settings\Roles\IndexRoleController;
use App\Http\Controllers\Settings\Roles\ShowRoleController;
use App\Http\Controllers\Settings\Roles\StoreRoleController;
use App\Http\Controllers\Settings\Roles\UpdateRoleController;
use Illuminate\Support\Facades\Route;

Route::post('role', StoreRoleController::class)->name('role.store');
Route::get('role', IndexRoleController::class)->name('role.index');
Route::get('{id}/role', ShowRoleController::class)->name('role.show');
Route::put('{id}/role', UpdateRoleController::class)->name('role.update');
Route::get('permissions', IndexPermissionController::class)->name('permission.index');
