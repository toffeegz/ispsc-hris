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
        'non_teaching',
        'color',
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


    // 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            $department->color = self::generateUniqueBrightColor();
        });
    }

    public static function generateUniqueBrightColor()
    {
        $maxAttempts = 50; // Set a maximum number of attempts to prevent infinite looping
    
        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            // Generate random HSL values for hue (0-360), saturation (50-100), and lightness (50-100)
            $hue = mt_rand(0, 360);
            $saturation = mt_rand(50, 100);
            $lightness = mt_rand(50, 100);
    
            // Convert HSL to RGB
            $rgbColor = self::hslToRgb($hue, $saturation, $lightness);
            $hexColor = self::rgbToHex($rgbColor);
    
            // Check if the generated color is too similar to any existing color
            $similarColor = self::isColorTooSimilar($hexColor);
    
            if (!$similarColor) {
                return $hexColor; // Return the color if it's sufficiently different
            }
        }
    
        // If it couldn't find a sufficiently different color after max attempts, return a default color
        return '#FFFFFF'; // Return a default color (white) or handle it based on your application's logic
    }
    
    public static function isColorTooSimilar($hexColor)
    {
        // Define a threshold for similarity (adjust as needed)
        $threshold = 30; // Example threshold
    
        // Retrieve all colors from the database
        $departments = self::pluck('color');
    
        foreach ($departments as $existingColor) {
            // Convert existing color to RGB for comparison
            $existingRgb = self::hexToRgb($existingColor);
    
            // Convert the generated color to RGB for comparison
            $generatedRgb = self::hexToRgb($hexColor);
    
            // Calculate the difference in hue, saturation, and lightness
            $hueDiff = abs($existingRgb['hue'] - $generatedRgb['hue']);
            $satDiff = abs($existingRgb['saturation'] - $generatedRgb['saturation']);
            $lightDiff = abs($existingRgb['lightness'] - $generatedRgb['lightness']);
    
            // Check if the color difference is within the threshold
            if ($hueDiff <= $threshold && $satDiff <= $threshold && $lightDiff <= $threshold) {
                return true; // Color is too similar
            }
        }
    
        return false; // Color is sufficiently different
    }
    
    
    // Functions to convert HSL to RGB and RGB to HEX (helper functions)
    public static function hslToRgb($h, $s, $l)
    {
        $h /= 360;
        $s /= 100;
        $l /= 100;
    
        $r = $g = $b = 0;
    
        if ($s === 0) {
            $r = $g = $b = $l; // Achromatic color (gray)
        } else {
            $hue2rgb = function ($p, $q, $t) {
                if ($t < 0) $t += 1;
                if ($t > 1) $t -= 1;
                if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
                if ($t < 1/2) return $q;
                if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
                return $p;
            };
    
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;
    
            $r = $hue2rgb($p, $q, $h + 1/3);
            $g = $hue2rgb($p, $q, $h);
            $b = $hue2rgb($p, $q, $h - 1/3);
        }
    
        return [
            'red' => round($r * 255),
            'green' => round($g * 255),
            'blue' => round($b * 255),
            'hue' => $h,
            'saturation' => $s,
            'lightness' => $l,
        ];
    }
    
    public static function rgbToHex($rgb)
    {
        return sprintf("#%02x%02x%02x", $rgb['red'], $rgb['green'], $rgb['blue']);
    }
    
    public static function hexToRgb($hex)
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        list($h, $s, $l) = self::rgbToHsl($r, $g, $b);
    
        return [
            'red' => $r,
            'green' => $g,
            'blue' => $b,
            'hue' => $h,
            'saturation' => $s,
            'lightness' => $l,
        ];
    }
    
    public static function rgbToHsl($r, $g, $b)
    {
        $r /= 255;
        $g /= 255;
        $b /= 255;
    
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
    
        $h = $s = $l = ($max + $min) / 2;
    
        if ($max === $min) {
            $h = $s = 0; // Achromatic
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
    
            switch ($max) {
                case $r:
                    $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                    break;
                case $g:
                    $h = ($b - $r) / $d + 2;
                    break;
                case $b:
                    $h = ($r - $g) / $d + 4;
                    break;
            }
    
            $h /= 6;
        }
    
        return [$h * 360, $s * 100, $l * 100];
    }
    
}
