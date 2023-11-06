<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrEvaluation extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $appends = ['total_average_rating', 'adjectival_rating'];

    protected $fillable = [
        'employee_id',
        'ipcr_period_id',
        'overall_rating',
        'reviewed_by',
        'recommending_approval',
    ];

    public function getTotalAverageRatingAttribute()
    {
        // Calculate and return the total average rating as the average of rating_a values for all evaluations
        return $this->evaluations->avg('rating_a');
    }

    public function getAdjectivalRatingAttribute()
    {
        // Define the mapping of overall ratings to adjectival ratings
        $adjectivalRatings = [
            5 => 'Outstanding',
            4 => 'Very Satisfactory',
            3 => 'Satisfactory',
            2 => 'Unsatisfactory',
            1 => 'Poor',
        ];

        // Get the total average rating
        $totalAverageRating = $this->getTotalAverageRatingAttribute();

        // Use the mapping to determine the adjectival rating
        return $adjectivalRatings[$totalAverageRating] ?? 'Unknown';
    }


    public function evaluations()
    {
        return $this->hasMany(IpcrEvaluationItem::class, 'evaluation_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? null;
        $query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('employee', function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('employee_id', 'like', '%' . $search . '%');
                });
            });
        });
    }
}
