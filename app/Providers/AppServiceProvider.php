<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Utils\File\FileService;
use App\Services\Utils\File\FileServiceInterface;
use App\Services\Utils\Response\ResponseService;
use App\Services\Utils\Response\ResponseServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileServiceInterface::class, FileService::class);
        $this->app->bind(ResponseServiceInterface::class, ResponseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
