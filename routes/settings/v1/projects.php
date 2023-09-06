<?php

use App\Http\Controllers\Settings\Projects\StoreProjectController;
use Illuminate\Support\Facades\Route;

Route::post('projects', StoreProjectController::class)->name('projects.store');
