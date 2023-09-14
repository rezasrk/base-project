<?php

use App\Http\Controllers\Supply\Categories\StoreCategoryController;
use Illuminate\Support\Facades\Route;

Route::post('categories', StoreCategoryController::class)->name('categories.store');
