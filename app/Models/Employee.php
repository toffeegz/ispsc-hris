<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'last_name',
        'first_name',
        'middle_name',
        'name_ext',
        'birth_date',
        'birth_place',
        'sex',
        'civil_status',
        'citizenship',
        'email',
        'tel_no',
        'mobile_no',
        'date_hired',
        'user_id',
        'department_id',
        'position_id',
        'employment_status_id',
        'schedule_id',
        'reason_for_deletion',
        'deleted_by'
    ];

    protected $appends = ['full_name', 'full_name_formal', 'is_flexible', 'employment_status_name', 'deleted_by_name']; 

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query
            ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $searchTerm = '%' . $search . '%';
                    $query->where('last_name', 'ILIKE', $searchTerm)
                        ->orWhere('first_name', 'ILIKE', $searchTerm)
                        ->orWhere('middle_name', 'ILIKE', $searchTerm)
                        ->orWhere('name_ext', 'ILIKE', $searchTerm)
                        ->orWhere('email', 'ILIKE', $searchTerm)
                        ->orWhere('mobile_no', 'ILIKE', $searchTerm)
                        ->orWhere('employee_id', 'ILIKE', $searchTerm);
                });
            }
        );
    }

    public function getFullNameAttribute()
    {
        // Assuming that 'first_name', 'middle_name', and 'last_name' are columns in your Employee model
        $full_name = $this->first_name;

        // Check if middle name exists
        if ($this->middle_name) {
            // Get the first character of the middle name as the initial
            $middle_initial = substr($this->middle_name, 0, 1);
            $full_name .= ' ' . $middle_initial . '.';
        }

        $full_name .= ' ' . $this->last_name;

        return $full_name;
    }

    public function getFullNameFormalAttribute()
    {
        // Assuming that 'first_name', 'middle_name', and 'last_name' are columns in your Employee model
        $full_name = $this->last_name . ", " . $this->first_name;

        // Check if middle name exists
        if ($this->middle_name) {
            // Get the first character of the middle name as the initial
            $middle_initial = substr($this->middle_name, 0, 1);
            $full_name .= ' ' . $middle_initial . '.';
        }

        return $full_name;
    }

    public function getDeletedByNameAttribute()
    {
        return $this->deletedBy ? $this->deletedBy->full_name_formal : null;
    }

    public function deletedBy()
    {
        return $this->belongsTo(Employee::class, 'deleted_by');
    }

    public function getIsFlexibleAttribute()
    {
        // Assuming you have a relationship to the Schedule model named 'schedule'
        $schedule = $this->schedule;

        if ($schedule) {
            // Replace this condition with your specific logic to determine flexibility
            return !$schedule->is_default;
        }

        return false; // Return a default value in case there's no associated schedule
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function employment_status()
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_status_id');
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'employee_trainings');
    }

    public function educational_backgrounds()
    {
        return $this->hasMany(EducationalBackground::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')->withDefault(function ($schedule) {
            $defaultSchedule = Schedule::where('is_default', true)->first();
            if ($defaultSchedule) {
                $schedule->name = $defaultSchedule->name;
                $schedule->is_default = $defaultSchedule->is_default;
                $schedule->time_in = $defaultSchedule->time_in;
                $schedule->time_out = $defaultSchedule->time_out;
                $schedule->is_deletable = $defaultSchedule->is_deletable;
            }
        });
    }

    public function getEmploymentStatusNameAttribute()
    {
        $employmentStatus = $this->employment_status()->first();

        if ($employmentStatus) {
            return $employmentStatus->name;
        }

        return null; 
    }

    public function awards() 
    {
        return $this->hasMany(Award::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function ipcrEvaluations()
    {
        return $this->hasMany(IpcrEvaluation::class, 'employee_id');
    }
}
