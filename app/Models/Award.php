<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Award extends Model
{
    use Uuid, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'award_name',
        'remarks',
        'date_awarded',
    ];

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
                ->orWhere('award_name', 'like', '%' . $search . '%');
            });
        });
    }    

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
