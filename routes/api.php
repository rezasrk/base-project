<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SelectProjectController;
use App\Http\Controllers\Auth\UserProjectsController;
use App\Http\Controllers\Profile\V1\ChangeUserPasswordController;
use App\Http\Controllers\Profile\V1\DeleteSignatureFileController;
use App\Http\Controllers\Profile\V1\ShowUserProfileController;
use App\Http\Controllers\Profile\V1\UpdateUserProfileController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user-projects', UserProjectsController::class)->name('user-projects');
    Route::post('select-project', SelectProjectController::class)->name('select-project');

    Route::put('update-user-profile', UpdateUserProfileController::class)->name('update-user-profile');
    Route::get('show-user-profile', ShowUserProfileController::class)->name('show-user-profile');
    Route::put('change-user-password', ChangeUserPasswordController::class)->name('change-user-password');
    Route::delete('delete-signature', DeleteSignatureFileController::class)->name('delete-signature');
});
