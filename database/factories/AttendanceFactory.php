<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use Carbon\Carbon;
use DateInterval;
use DateTime;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lowerTime = Carbon::createFromTime(6, 0, 0);
        $upperTime = Carbon::createFromTime(8, 0, 0);

        $timeIn = $this->faker->boolean ? $this->faker->dateTimeBetween($lowerTime, $upperTime) : Carbon::createFromTime(8, 0, 0);

        $lowerTimeOut = Carbon::createFromTime(16, 0, 0);
        $upperTimeOut = Carbon::createFromTime(20, 0, 0);

        $timeOut = $this->faker->dateTimeBetween($lowerTimeOut, $upperTimeOut);

        $carbonTimeIn = Carbon::instance($timeIn);
        $carbonTimeOut = Carbon::instance($timeOut);

        // Calculate undertime for time_in
        $undertimeIn = 0;
        if ($carbonTimeIn->gt(Carbon::createFromTime(8, 0, 0))) {
            $undertimeIn = $carbonTimeIn->diffInMinutes(Carbon::createFromTime(8, 0, 0));
        }

        // Calculate undertime for time_out
        $undertimeOut = 0;
        if ($carbonTimeOut->lt(Carbon::createFromTime(16, 30, 0))) {
            $undertimeOut = Carbon::createFromTime(16, 30, 0)->diffInMinutes($carbonTimeOut);
        }

        return [
            'employee_id' => function () {
                return Employee::factory()->create()->id;
            },
            'time_in' => $carbonTimeIn->format('Y-m-d H:i:s'),
            'time_out' => $carbonTimeOut->format('Y-m-d H:i:s'),
            'is_flexible' => $this->faker->boolean,
            'undertime' => $undertimeIn + $undertimeOut,
        ];
    }
}



