<?php

namespace App\Services\Attendance;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use Illuminate\Http\UploadedFile;

interface AttendanceServiceInterface
{
    public function storeDat($file);
    public function timeInAndOut($employee_data, $employeeId, $schedule);
}
