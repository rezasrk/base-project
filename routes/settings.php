<?php

use App\Http\Controllers\Settings\IndexPermissionController;
use App\Http\Controllers\Settings\StoreRoleController;
use Illuminate\Support\Facades\Route;

Route::post('role', StoreRoleController::class)->name('role.store');
Route::get('permissions', IndexPermissionController::class)->name('permission.index');
