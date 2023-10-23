<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Utils\File\FileService;
use App\Services\Utils\File\FileServiceInterface;
use App\Services\Utils\Response\ResponseService;
use App\Services\Utils\Response\ResponseServiceInterface;
use App\Services\Attendance\AttendanceService;
use App\Services\Attendance\AttendanceServiceInterface;
use App\Services\Dashboard\DashboardService;
use App\Services\Dashboard\DashboardServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileServiceInterface::class, FileService::class);
        $this->app->bind(ResponseServiceInterface::class, ResponseService::class);
        
        $this->app->bind(AttendanceServiceInterface::class, AttendanceService::class);
        $this->app->bind(DashboardServiceInterface::class, DashboardService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
