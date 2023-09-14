<?php

use App\Http\Controllers\Supply\Categories\IndexCategoryController;
use App\Http\Controllers\Supply\Categories\ShowCategoryController;
use App\Http\Controllers\Supply\Categories\StoreCategoryController;
use App\Http\Controllers\Supply\Categories\UpdateCategoryController;
use Illuminate\Support\Facades\Route;

Route::post('categories', StoreCategoryController::class)->name('categories.store');
Route::get('{id}/categories', ShowCategoryController::class)->name('categories.show');
Route::put('{id}/categories', UpdateCategoryController::class)->name('categories.update');
Route::get('categories', IndexCategoryController::class)->name('categories.index');
