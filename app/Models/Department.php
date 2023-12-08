<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $fillable = [
        'name',
        'acronym',
        'description',
        'employee_id',
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

    public function getTotalAverageRatingByPeriod()
    {
        $ipcrPeriods = IpcrPeriod::all();

        $ratingsByPeriod = [];

        foreach ($ipcrPeriods as $index => $period) {
            $ratings = IpcrEvaluation::query()
                ->select('departments.id as department_id', 'departments.name as department_name')
                ->join('employees', 'ipcr_evaluations.employee_id', '=', 'employees.id')
                ->join('departments', 'employees.department_id', '=', 'departments.id')
                ->where('ipcr_period_id', $period->id)
                ->groupBy('departments.id', 'departments.name')
                ->selectRaw('SUM(final_average_rating) as total_rating, COUNT(final_average_rating) as evaluation_count')
                ->get();

            foreach ($ratings as $rating) {
                $finalAverageRating = $rating->total_rating / max($rating->evaluation_count, 1); // Avoid division by zero
                $ratingsByPeriod[$index]['name'] = $period->start_month . ' - ' . $period->end_month . ' ' . $period->year;
                $ratingsByPeriod[$index]['final_average_rating'] = $finalAverageRating;
            }
        }

        return $ratingsByPeriod;
    }


    public function headEmployee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function setAcronymAttribute($value)
    {
        $this->attributes['acronym'] = strtoupper($value);
    }

}
