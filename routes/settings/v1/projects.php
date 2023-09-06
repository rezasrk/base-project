<?php

use App\Http\Controllers\Settings\V1\Projects\ProjectSettingsController;
use App\Http\Controllers\Settings\V1\Projects\StoreProjectController;
use Illuminate\Support\Facades\Route;

Route::post('projects', StoreProjectController::class)->name('projects.store');
Route::put('{id}/projects-settings', ProjectSettingsController::class)->name('projects-settings');
