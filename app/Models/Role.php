<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    public const ID_ADMIN = "0db020f7-9fcf-420c-b3d4-3c87f0c27f68";

}
