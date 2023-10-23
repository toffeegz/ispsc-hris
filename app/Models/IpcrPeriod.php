<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrPeriod extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'start_month',
        'end_month',
        'year'
    ];
}
