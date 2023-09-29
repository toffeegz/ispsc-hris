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
    ];

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
}
