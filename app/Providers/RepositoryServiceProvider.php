<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// base
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
//
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Verification\VerificationRepository;
use App\Repositories\Verification\VerificationRepositoryInterface;

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
        $this->app->bind(VerificationRepositoryInterface::class, VerificationRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
