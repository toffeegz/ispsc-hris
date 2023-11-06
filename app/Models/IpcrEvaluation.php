<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrEvaluation extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'ipcr_period_id',
        'overall_rating',
        'reviewed_by',
        'recommending_approval',
    ];

    public function evaluations()
    {
        return $this->hasMany(IpcrEvaluationItem::class, 'evaluation_id');
    }
}
