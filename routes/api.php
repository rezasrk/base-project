<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SelectProjectController;
use App\Http\Controllers\Auth\UserProjectsController;
use App\Http\Controllers\Profile\UpdateUserProfileController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user-projects', UserProjectsController::class)->name('user-projects');
    Route::post('select-project', SelectProjectController::class)->name('select-project');

    Route::post('update-user-profile', UpdateUserProfileController::class)->name('update-user-profile');
});
