<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'date_filed',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'leave_type_id',
        'status',
        'remarks',
        'credit',
        'details_of_leave',
        'disapproved_for',
        'approved_for',
        'approved_for_type',
        'commutation',
    ];
    protected $appends = ['status', 'type'];

    public function scopeFilter($query, array $filters)
    {
        $query->when(isset($filters['status']), function ($query) use ($filters) {
            $query->where('status', $filters['status']);
        });

        $search = $filters['search'] ?? null;
        
        $query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('employee', function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('employee_id', 'like', '%' . $search . '%');
                })
                ->orWhereHas('leave_type', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('date_start', 'like', '%' . $search . '%')
                ->orWhere('date_end', 'like', '%' . $search . '%')
                ->orWhere('details_of_leave', 'like', '%' . $search . '%');
            });
        });
    }



    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function getStatusAttribute()
    {
        if ($this->attributes['status'] === 0) {
            return 'On-time';
        } elseif ($this->attributes['status'] === 1) {
            return 'Late Filing';
        } else {
            return 'Unknown'; // If the status doesn't match expected values
        }
    }

    public function getTypeAttribute()
    {
        // Assuming 'acronym' is the attribute you want to retrieve from the related LeaveType model
        if ($this->leave_type) {
            return $this->leave_type->acronym;
        }
        
        return null; // Or any default value if the relationship doesn't exist or has no acronym
    }
}
