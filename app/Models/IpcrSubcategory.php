<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrSubcategory extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'name',
        'weight',
        'order',
        'parent_id',
    ];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query
            ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('weight', 'like', '%' . $search . '%');
                });
            }
        );
    }

    public function parentSubcategory()
    {
        return $this->belongsTo(IpcrSubcategory::class, 'parent_id');
    }

    public function childSubcategories()
    {
        return $this->hasMany(IpcrSubcategory::class, 'parent_id');
    }

    public function evaluations()
    {
        return $this->hasMany(IpcrEvaluationItem::class, 'subcategory_id')
            ->whereNotNull('subcategory_id');
    }

}
