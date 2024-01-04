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
        'reviewed_by',
        'recommending_approval',
        'mean_score_strategic',
        'mean_score_core',
        'mean_score_support',
        'weighted_average_strategic',
        'weighted_average_core',
        'weighted_average_support',
        'final_average_rating',
        'data'
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
    
        // Get the total average rating and convert it to a whole number
        $totalAverageRating = (int) round($this->final_average_rating);
    
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

    public function recommendingApproval()
    {
        return $this->belongsTo(Employee::class, 'recommending_approval');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(Employee::class, 'reviewed_by');
    }
    
    public function ipcrPeriod()
    {
        return $this->belongsTo(IpcrPeriod::class, 'ipcr_period_id');
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
