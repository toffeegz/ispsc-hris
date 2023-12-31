<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrSubcategoryRating extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'ipcr_evaluation_id',
        'overall_rating',
    ];
}
