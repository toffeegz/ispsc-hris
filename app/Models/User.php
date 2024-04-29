<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Uuid, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['is_admin', 'employee_id', 'full_name_formal', 'role_name'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query
            ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $search = '%' . $search . '%';
                    $query->where('name', 'ILIKE', $search)
                        ->orWhere('email', 'ILIKE', $search);
                });
            }
        );
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function getIsAdminAttribute()
    {
        return $this->role_id === Role::ID_ADMIN;
    }

    public function getEmployeeIdAttribute()
    {
        return $this->employee ? $this->employee->employee_id : '';
    }

    public function getFullNameFormalAttribute()
    {
        return $this->employee ? $this->employee->full_name_formal : '';
    }

    public function getRoleNameAttribute()
    {
        return $this->role ? $this->role->name : '';
    }
}
