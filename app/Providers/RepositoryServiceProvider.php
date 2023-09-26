<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// base
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
//
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // base
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        // 
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
