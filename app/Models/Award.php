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

    protected $casts = [
        'date_awarded' => 'datetime',
    ];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? null;
        $query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $searchTerm = '%' . $search . '%';

                $query->whereHas('employee', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('first_name', 'ILIKE', $searchTerm)
                        ->orWhere('last_name', 'ILIKE', $searchTerm)
                        ->orWhere('employee_id', 'ILIKE', $searchTerm);
                })
                ->orWhere('award_name', 'ILIKE', $searchTerm);
            });
        });
    }    

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
