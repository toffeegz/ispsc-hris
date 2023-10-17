<?php

namespace App\Services\Attendance;

use Illuminate\Support\Facades\Log;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Services\Attendance\AttendanceServiceInterface;
use App\Repositories\Verification\VerificationRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportAttendance;

class AttendanceService implements AttendanceServiceInterface
{
    private AttendanceRepositoryInterface $modelRepository;

    public function __construct(
        AttendanceRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function storeDat($file)
    {
        try {
            $contents = file_get_contents($file->getRealPath());
            $employees_attendance = $this->groupedByEmployeeDat(explode("\n", $contents));
            $employeeIds = collect($employees_attendance)->keys();

            // Filter out employee_ids that do not exist in the employees table
            $existingEmployees = Employee::whereIn('employee_id', $employeeIds)->get();

            $all_attendance = [];
            foreach ($existingEmployees as $employee) {
                $employee_id = $employee->employee_id;
                $employee_data = $employees_attendance[$employee_id];
                $employee_name = $employee->full_name;
                $employee_attendance = $this->timeInAndOut($employee_data, $employee->id, $employee->schedule);
                $all_attendance += $employee_attendance;
            }
            Attendance::insert($all_attendance);
            return "Imported Successful!";
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }

    public function storeXlsx($file)
    {
        try {
            $lines = Excel::toArray(new ImportAttendance(), $file);
            $employees_attendance = $this->groupedByEmployeeXlsx($lines[0]);
            $employeeIds = collect($employees_attendance)->keys();

            // Filter out employee_ids that do not exist in the employees table
            $existingEmployees = Employee::whereIn('employee_id', $employeeIds)->get();
            
            $all_attendance = [];
            foreach ($existingEmployees as $employee) {
                $employee_id = $employee->employee_id;
                $employee_data = $employees_attendance[$employee_id];
                $employee_name = $employee->full_name;
                $employee_attendance = $this->timeInAndOut($employee_data, $employee->id, $employee->schedule);
                $all_attendance += $employee_attendance;
            }
            Attendance::insert($all_attendance);
            return "Imported Successful!";
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([$exception->getMessage()]);
        }
    }

    public function groupedByEmployeeDat($lines)
    {
        $data = collect();
        foreach ($lines as $line) {
            $fields = explode("\t", $line); // Split the line by tabs

            if (count($fields) >= 2) {
                $employeeId = $fields[0];
                $datetime = $fields[1];

                // Parse the datetime to separate date and time
                list($date, $time) = explode(' ', $datetime);

                // Add the data to the collection grouped by employee_id and date
                if (!$data->has($employeeId)) {
                    $data->put($employeeId, collect());
                }

                if (!$data[$employeeId]->has($date)) {
                    $data[$employeeId]->put($date, collect());
                }

                $dateCollection = $data[$employeeId][$date];

                // Push the time for the current date
                $dateCollection->push($time);
            }
        }
        return $data;
    }

    public function groupedByEmployeeXlsx($lines)
    {
        $data = collect();

        foreach ($lines as $fields) {
            if (count($fields) >= 2) {
                $employeeId = $fields[0];
                $UNIX_DATE = ($fields[1] - 25569) * 86400;
                $datetime = gmdate("Y-m-d H:i:s", $UNIX_DATE);
                // Parse the datetime to separate date and time
                list($date, $time) = explode(' ', $datetime);

                // Add the data to the collection grouped by employee_id and date
                if (!$data->has($employeeId)) {
                    $data->put($employeeId, collect());
                }

                if (!$data[$employeeId]->has($date)) {
                    $data[$employeeId]->put($date, collect());
                }

                $dateCollection = $data[$employeeId][$date];

                // Push the time for the current date
                $dateCollection->push($time);
            }
        }
        return $data;
    }

    public function timeInAndOut($employee_data, $employeeId, $schedule)
    {
        $data = [];

        // Iterate over each date's data for the employee
        $employee_data->each(function ($date_data, $date) use (&$data, $employeeId, $schedule) {
            // Sort the times for the date
            $date_data = collect($date_data)->sort()->values()->all();

            // Convert times to Carbon objects
            $time_in = Carbon::parse($date . " " . reset($date_data));
            $time_out = Carbon::parse($date . " " . end($date_data));

            $schedule_time_in = Carbon::parse($date . " " . $schedule->time_in);
            $schedule_time_out = Carbon::parse($date . " " . $schedule->time_out);

            // Calculate undertime based on the schedule
            $undertime = 0;

            // Check if time_in is later than scheduled time_in
            if ($time_in->gt($schedule_time_in)) {
                $undertime += $time_in->diffInMinutes($schedule_time_in);
            }

            // Check if time_out is earlier than scheduled time_out
            if ($time_out->lt($schedule_time_out)) {
                $undertime += $schedule_time_out->diffInMinutes($time_out);
            }

            $data[$date] = [
                'id' => Str::uuid(),
                'employee_id' => $employeeId,
                'date' => $date,
                'time_in' => $time_in->format('Y-m-d H:i:s'), // Format as "Y-m-d H:i:s"
                'time_out' => $time_out->format('Y-m-d H:i:s'), // Format as "Y-m-d H:i:s"
                'schedule_time_in' => $schedule->time_in,
                'schedule_time_out' => $schedule->time_out,
                'undertime' => $undertime,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        });

        return $data;
    }
}
