<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTraining extends Model
{
    use Uuid, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'training_id',
    ];
}
