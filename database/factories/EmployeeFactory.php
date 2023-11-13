<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sexOptions = config('hris_employee.sex');
        $civilStatusOptions = config('hris_employee.civil_status');

        return [
            'employee_id' => $this->faker->unique()->randomNumber(6),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'name_ext' => $this->faker->optional()->suffix,
            'birth_date' => $this->faker->date,
            'birth_place' => $this->faker->city,
            'sex' => $this->faker->randomElement($sexOptions), // Use the 'sex' options from the config
            'civil_status' => $this->faker->randomElement($civilStatusOptions), // Use the 'civil_status' options from the config
            'citizenship' => $this->faker->country,
            'email' => $this->faker->unique()->safeEmail,
            'tel_no' => $this->faker->optional()->phoneNumber,
            'mobile_no' => $this->faker->optional()->phoneNumber,
            'date_hired' => $this->faker->date,
        ];
    }
}
