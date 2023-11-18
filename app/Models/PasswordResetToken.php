<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordResetToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    // Define the expiration duration in minutes (e.g., 60 minutes for 1 hour)
    const EXPIRATION_DURATION_MINUTES = 60;

    public function isExpired()
    {
        // Calculate the expiration time by adding the expiration duration to the 'created_at' timestamp
        $expirationTime = Carbon::parse($this->created_at)->addMinutes(self::EXPIRATION_DURATION_MINUTES);

        // Check if the current time is past the expiration time
        return Carbon::now()->isAfter($expirationTime);
    }
}
