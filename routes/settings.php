<?php

use App\Http\Controllers\Settings\IndexPermissionController;
use App\Http\Controllers\Settings\IndexRoleController;
use App\Http\Controllers\Settings\ShowRoleController;
use App\Http\Controllers\Settings\StoreRoleController;
use App\Http\Controllers\Settings\UpdateRoleController;
use Illuminate\Support\Facades\Route;

Route::post('role', StoreRoleController::class)->name('role.store');
Route::get('role', IndexRoleController::class)->name('role.index');
Route::get('{id}/role', ShowRoleController::class)->name('role.show');
Route::put('{id}/role', UpdateRoleController::class)->name('role.update');
Route::get('permissions', IndexPermissionController::class)->name('permission.index');
