<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'time_in',
        'time_out',
        'undertime',
        'is_flexible',
    ];

    protected $appends = ["undertime_str"];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? null;
        $query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('employee', function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('employee_id', 'like', '%' . $search . '%');
                });
            });
        });
    }

    public function getUndertimeStrAttribute()
    {
        $minutes = $this->attributes['undertime'];

        if(!$minutes) {
            return null;
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        
        if ($hours == 0) {
            $str = "{$remainingMinutes}min";
            if($remainingMinutes > 1) {
                $str = $str . "s";
            } 
            return $str;
        }
         elseif ($remainingMinutes == 0) {
            $str = "{$hours}hr";
            if($hours > 1) {
                $str = $str . "s";
            }
        } else {
            $str = "{$hours}hr";
            if($hours > 1) {
                $str = $str . "s";
            }
            $str = $str . " " . "{$remainingMinutes}min";
            if($remainingMinutes > 1) {
                $str = $str . "s";
            }
            return $str;
        }
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
