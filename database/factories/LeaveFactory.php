<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\LeaveType;

class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'date_filed' => $this->faker->date,
            'date_start' => $this->faker->date,
            'date_end' => $this->faker->date,
            'time_start' => $this->faker->time(),
            'time_end' => $this->faker->time(),
            'leave_type_id' => LeaveType::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['approved', 'rejected', 'pending']),
            'details_of_leave' => $this->faker->paragraph,
            'disapproved_for' => $this->faker->optional()->sentence,
            'approved_for' => $this->faker->optional()->sentence,
            'approved_for_type' => $this->faker->optional()->randomElement([1, 2, 3]),
            'commutation' => $this->faker->boolean,
        ];
    }
}
