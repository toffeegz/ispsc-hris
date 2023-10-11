<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// base
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
//
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\EducationalBackground\EducationalBackgroundRepository;
use App\Repositories\EducationalBackground\EducationalBackgroundRepositoryInterface;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\EmploymentStatus\EmploymentStatusRepository;
use App\Repositories\EmploymentStatus\EmploymentStatusRepositoryInterface;
use App\Repositories\Leave\LeaveRepository;
use App\Repositories\Leave\LeaveRepositoryInterface;
use App\Repositories\LeaveType\LeaveTypeRepository;
use App\Repositories\LeaveType\LeaveTypeRepositoryInterface;
use App\Repositories\Position\PositionRepository;
use App\Repositories\Position\PositionRepositoryInterface;
use App\Repositories\Training\TrainingRepository;
use App\Repositories\Training\TrainingRepositoryInterface;
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
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(EducationalBackgroundRepositoryInterface::class, EducationalBackgroundRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(EmploymentStatusRepositoryInterface::class, EmploymentStatusRepository::class);
        $this->app->bind(LeaveRepositoryInterface::class, LeaveRepository::class);
        $this->app->bind(LeaveTypeRepositoryInterface::class, LeaveTypeRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(TrainingRepositoryInterface::class, TrainingRepository::class);
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
