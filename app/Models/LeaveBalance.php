<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveBalance extends Model
{
    use Uuid, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'remaining_vl',
        'remaining_sl',
        'year',
    ];

    protected $appends = ['department', 'position'];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? null;
        $query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('employee', function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('employee_id', 'like', '%' . $search . '%');
                })
                ->orWhere('remaining_vl', 'like', '%' . $search . '%')
                ->orWhere('remaining_sl', 'like', '%' . $search . '%');
            });
        });
    }    

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getDepartmentAttribute()
    {
        if ($this->employee && $this->employee->department) {
            return $this->employee->department->acronym;
        }

        return null;
    }

    public function getPositionAttribute()
    {
        if ($this->employee && $this->employee->position) {
            return $this->employee->position->name;
        }

        return null;
    }
}
