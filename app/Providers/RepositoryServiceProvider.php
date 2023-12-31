<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// base
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
//
use App\Repositories\Attendance\AttendanceRepository;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Repositories\Award\AwardRepository;
use App\Repositories\Award\AwardRepositoryInterface;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\EducationalBackground\EducationalBackgroundRepository;
use App\Repositories\EducationalBackground\EducationalBackgroundRepositoryInterface;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\EmploymentStatus\EmploymentStatusRepository;
use App\Repositories\EmploymentStatus\EmploymentStatusRepositoryInterface;
use App\Repositories\IpcrEvaluation\IpcrEvaluationRepository;
use App\Repositories\IpcrEvaluation\IpcrEvaluationRepositoryInterface;
use App\Repositories\IpcrEvaluationItem\IpcrEvaluationItemRepository;
use App\Repositories\IpcrEvaluationItem\IpcrEvaluationItemRepositoryInterface;
use App\Repositories\IpcrSubcategory\IpcrSubcategoryRepository;
use App\Repositories\IpcrSubcategory\IpcrSubcategoryRepositoryInterface;
use App\Repositories\Leave\LeaveRepository;
use App\Repositories\Leave\LeaveRepositoryInterface;
use App\Repositories\LeaveBalance\LeaveBalanceRepository;
use App\Repositories\LeaveBalance\LeaveBalanceRepositoryInterface;
use App\Repositories\LeaveType\LeaveTypeRepository;
use App\Repositories\LeaveType\LeaveTypeRepositoryInterface;
use App\Repositories\Opcr\OpcrRepository;
use App\Repositories\Opcr\OpcrRepositoryInterface;
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
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(AwardRepositoryInterface::class, AwardRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(EducationalBackgroundRepositoryInterface::class, EducationalBackgroundRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(EmploymentStatusRepositoryInterface::class, EmploymentStatusRepository::class);
        $this->app->bind(IpcrEvaluationRepositoryInterface::class, IpcrEvaluationRepository::class);
        $this->app->bind(IpcrEvaluationItemRepositoryInterface::class, IpcrEvaluationItemRepository::class);
        $this->app->bind(IpcrSubcategoryRepositoryInterface::class, IpcrSubcategoryRepository::class);
        $this->app->bind(LeaveRepositoryInterface::class, LeaveRepository::class);
        $this->app->bind(LeaveBalanceRepositoryInterface::class, LeaveBalanceRepository::class);
        $this->app->bind(LeaveTypeRepositoryInterface::class, LeaveTypeRepository::class);
        $this->app->bind(OpcrRepositoryInterface::class, OpcrRepository::class);
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
