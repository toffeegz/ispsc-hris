<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrEvaluationItem extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'name',
        'evaluation_id',
        'category_id',
        'subcategory_id',
        'item_id',
        'major_final_output',
        'performance_indicators',
        'target_of_accomplishment',
        'actual_accomplishments',
        'rating_q',
        'rating_e',
        'rating_t',
        'rating_a',
        'remarks',
    ];
}
