<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrItem extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'weight'
    ];
}
