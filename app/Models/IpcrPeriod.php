<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpcrPeriod extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $appends = ['ipcr_period_date_range'];

    protected $fillable = [
        'start_month',
        'end_month',
        'year'
    ];

    public function getIpcrPeriodDateRangeAttribute()
    {
        $startMonth = date('M', mktime(0, 0, 0, $this->start_month, 1));
        $endMonth = date('M', mktime(0, 0, 0, $this->end_month, 1));

        return "$startMonth to $endMonth {$this->year}";
    }
}
