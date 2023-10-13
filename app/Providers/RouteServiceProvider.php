<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // 
            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/attendance.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/department.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/employee.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/employment_status.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/leave_type.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/leave.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/option.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/position.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/training.php'));

            Route::prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api/user.php'));


            // Route::prefix('api')
            //     ->middleware(['api', 'auth:sanctum'])
            //     ->group(base_path('routes/api/user.php'));
        });
    }
}
