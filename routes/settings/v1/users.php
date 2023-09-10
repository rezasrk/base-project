<?php

use App\Http\Controllers\Settings\V1\Users\IndexUserController;
use App\Http\Controllers\Settings\V1\Users\ShowUserController;
use App\Http\Controllers\Settings\V1\Users\StoreUserController;
use Illuminate\Support\Facades\Route;

Route::post('users', StoreUserController::class)->name('users.store');
Route::get('{id}/users', ShowUserController::class)->name('users.show');
Route::get('users', IndexUserController::class)->name('users.index');
