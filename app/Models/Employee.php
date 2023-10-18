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
        'schedule_id',
    ];

    protected $appends = ['full_name', 'is_flexible'];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query
            ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $query->where('last_name', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('middle_name', 'like', '%' . $search . '%')
                        ->orWhere('name_ext', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('mobile_no', 'like', '%' . $search . '%');
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



}
