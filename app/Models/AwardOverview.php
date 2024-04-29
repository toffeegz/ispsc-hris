<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardOverview extends Model
{
    use HasFactory;
    protected $table = 'awards_overview';

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
        $query
            ->when($filters['search'] ?? false, 
            function($query) use($search) {
                $query->where(function($query) use($search) {
                    $searchTerm = '%' . $search . '%';
                    $query->where('employee', 'ILIKE', $searchTerm)
                        ->orWhere('department_name', 'ILIKE', $searchTerm)
                        ->orWhere('award_name', 'ILIKE', $searchTerm);
                });
            }
        );
    }

    public function getDateAwardedAttribute($value)
    {
        $dates = json_decode($value, true);
        $formattedDates = collect($dates)->map(function ($date) {
            return date('M d, Y', strtotime($date));
        });
        $formattedDatesArray = $formattedDates->toArray();
        $formattedDatesString = implode(" | ", $formattedDatesArray);
        return $formattedDatesString;
    }
}
