<?php

use Illuminate\Support\Facades\Route;

$supplyRoutePath = base_path('routes/supply/v1/');

Route::prefix('supplies/v1/')->group(function () use ($supplyRoutePath) {
    Route::name('supplies.v1.')->group($supplyRoutePath.'categories.php');
});
