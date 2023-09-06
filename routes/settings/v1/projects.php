<?php

use App\Http\Controllers\Settings\Projects\ProjectSettingsController;
use App\Http\Controllers\Settings\Projects\StoreProjectController;
use Illuminate\Support\Facades\Route;

Route::post('projects', StoreProjectController::class)->name('projects.store');
Route::put('{id}/projects-settings', ProjectSettingsController::class)->name('projects-settings');
