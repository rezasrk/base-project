<?php

use App\Http\Controllers\Supply\Categories\IndexCategoryController;
use App\Http\Controllers\Supply\Categories\SearchCategoryByNameController;
use App\Http\Controllers\Supply\Categories\ShowCategoryController;
use App\Http\Controllers\Supply\Categories\SortCategoryController;
use App\Http\Controllers\Supply\Categories\StoreCategoryController;
use App\Http\Controllers\Supply\Categories\TransferCategoryController;
use App\Http\Controllers\Supply\Categories\UpdateCategoryController;
use Illuminate\Support\Facades\Route;

Route::post('categories', StoreCategoryController::class)->name('categories.store');
Route::get('{id}/categories', ShowCategoryController::class)->name('categories.show');
Route::put('{id}/categories', UpdateCategoryController::class)->name('categories.update');
Route::get('categories', IndexCategoryController::class)->name('categories.index');
Route::post('categories/sort', SortCategoryController::class)->name('categories.sort');
Route::post('categories/transfer', TransferCategoryController::class)->name('categories.transfer');
Route::get('categories/search-by-title', SearchCategoryByNameController::class)->name('categories.search-by-title');
