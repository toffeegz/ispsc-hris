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
        $adjectivalRatings = [
            'Outstanding' => [5],
            'Very Satisfactory' => [4, 4.99],
            'Satisfactory' => [3, 3.99],
            'Unsatisfactory' => [2, 2.99],
            'Poor' => [1, 1.99],
        ];
    
        // Iterate through adjectival ratings and return the corresponding rating
        foreach ($adjectivalRatings as $rating => $range) {
            if ($this->final_average_rating >= $range[0] && $this->final_average_rating <= end($range)) {
                return $rating;
            }
        }
    
        // If no matching range is found, return 'N/A'
        return 'N/A';
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
                    $searchTerm = '%' . $search . '%';
                    $subQuery->where('first_name', 'ILIKE', $searchTerm)
                        ->orWhere('last_name', 'ILIKE', $searchTerm)
                        ->orWhere('employee_id', 'ILIKE', $searchTerm);
                });
            });
        });
    }
}
