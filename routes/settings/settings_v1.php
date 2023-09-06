<?php

use Illuminate\Support\Facades\Route;

$settingRoutePath = base_path('routes/settings/v1/');


Route::prefix('settings/v1/')->group(function () use ($settingRoutePath) {
    Route::name('settings.v1.')->group($settingRoutePath . 'roles.php');
    Route::name('settings.v1.')->group($settingRoutePath . 'projects.php');
});
