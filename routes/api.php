<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SelectProjectController;
use App\Http\Controllers\Auth\UserProjectsController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('login');
Route::get('user-projects', UserProjectsController::class)->name('user-projects')->middleware('auth:sanctum');
Route::post('select-project', SelectProjectController::class)->name('select-project')->middleware('auth:sanctum');
