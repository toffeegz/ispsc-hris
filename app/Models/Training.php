<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'conducted_by',
        'period_from',
        'period_to',
        'hours',
        'type_of_ld',
        'url',
    ];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query
            ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $searchTerm = '%' . $search . '%';
                    $query->where('title', 'ILIKE', $searchTerm)
                        ->orWhere('description', 'ILIKE', $searchTerm)
                        ->orWhere('conducted_by', 'ILIKE', $searchTerm)
                        ->orWhere('type_of_ld', 'ILIKE', $searchTerm);
                });
            }
        );
    }

    public function employees() {
        return $this->belongsToMany(Employee::class, 'employee_trainings');
    }
}
