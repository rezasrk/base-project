<?php

use App\Http\Controllers\Settings\V1\Projects\ProjectSettingsController;
use App\Http\Controllers\Settings\V1\Projects\StoreProjectController;
use App\Http\Controllers\Settings\V1\Projects\UpdateProjectController;
use Illuminate\Support\Facades\Route;

Route::post('projects', StoreProjectController::class)->name('projects.store');
Route::put('{id}/projects-settings', ProjectSettingsController::class)->name('projects-settings');
Route::put('{id}/projects', UpdateProjectController::class)->name('project.update');
