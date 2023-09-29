<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'type'
    ];

    public function isExpired()
    {
        return $this->created_at->addMinutes(config('auth.verification.expire'))->isPast();
    }

}
