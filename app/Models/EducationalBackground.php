<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    use Uuid, SoftDeletes;

    protected $table = 'employee_educational_backgrounds';

    protected $fillable = [
        'employee_id',
        'level',
        'school_name',
        'degree',
        'period_from',
        'period_to',
        'units_earned',
        'year_graduated',
        'academic_honors_received',
    ];

}
