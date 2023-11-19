<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcr extends Model
{
    use HasFactory;

    protected $table = 'opcr'; 

    protected $appends = ['ipcr_period_name'];

    // Define the relationship to get the department head employee
    public function departmentHeadEmployee()
    {
        return $this->belongsTo(Employee::class, 'department_head');
    }

    // Define the relationship to get the department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Define the relationship to get the IPCR period
    public function ipcrPeriod()
    {
        return $this->belongsTo(IpcrPeriod::class, 'ipcr_period_id');
    }

    public function getIpcrPeriodNameAttribute()
    {
        if ($this->ipcrPeriod) {
            $startMonth = date("M", mktime(0, 0, 0, $this->ipcrPeriod->start_month, 1));
            $endMonth = date("M", mktime(0, 0, 0, $this->ipcrPeriod->end_month, 1));
    
            return $startMonth . ' - ' . $endMonth . ' ' . $this->ipcrPeriod->year;
        }
    
        return null; // Or any default value you prefer when ipcrPeriod is null
    }

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $ipcrPeriodId = $filters['ipcr_period_id'] ?? false;

        $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereHas('departmentHeadEmployee', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('department', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            });
        });

        $query->when($ipcrPeriodId, function (Builder $query) use ($ipcrPeriodId) {
            $query->where('ipcr_period_id', $ipcrPeriodId);
        });
    }
}
