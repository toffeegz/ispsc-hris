<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    public const SL_ID = "0baec48c-7589-481b-bad5-65ce778e6f2c";
    public const VL_ID = "0db020f7-9fcf-420c-b3d4-3c87f0c27f68";

    protected $fillable = [
        'name',
        'description',
        'is_deletable',
        'date_period',
        'acronym',
    ];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query
            ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
        );
    }
}
