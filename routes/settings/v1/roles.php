<?php

use App\Http\Controllers\Settings\Roles\IndexPermissionController;
use App\Http\Controllers\Settings\Roles\IndexRoleController;
use App\Http\Controllers\Settings\Roles\ShowRoleController;
use App\Http\Controllers\Settings\Roles\StoreRoleController;
use App\Http\Controllers\Settings\Roles\UpdateRoleController;
use Illuminate\Support\Facades\Route;

Route::post('roles', StoreRoleController::class)->name('roles.store');
Route::get('roles', IndexRoleController::class)->name('roles.index');
Route::get('{id}/roles', ShowRoleController::class)->name('roles.show');
Route::put('{id}/roles', UpdateRoleController::class)->name('roles.update');
Route::get('permissions', IndexPermissionController::class)->name('permission.index');
