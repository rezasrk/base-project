<?php

use Illuminate\Support\Facades\Route;

$settingRoutePath = base_path('routes/settings/v1/');

Route::prefix('settings/v1/role')->name('settings.v1.')->group($settingRoutePath . 'role.php');
