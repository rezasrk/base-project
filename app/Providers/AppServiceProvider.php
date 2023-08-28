<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerMigrationFiles();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerMigrationFiles()
    {
        $baseMigrationPath = database_path('migrations');

        $migrationPaths = collect(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseMigrationPath, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST))
            ->filter(function (SplFileInfo $item) {
                return $item->getType() == 'dir' || $item->getType() == 'file';
            })->map(function (SplFileInfo $item) {
                switch ($item->getType()) {
                    case 'dir':
                        return $item->getRealPath();
                    case 'file':
                        return dirname($item->getRealPath());
                }
            })->unique()
            ->values()
            ->all();

        $this->loadMigrationsFrom($migrationPaths);
    }
}
