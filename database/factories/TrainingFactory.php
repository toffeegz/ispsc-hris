<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Training;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $createdAt = Carbon::createFromTimestamp($this->faker->dateTimeBetween('-7 years', 'now')->getTimestamp());

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'conducted_by' => $this->faker->name,
            'period_from' => $this->faker->date,
            'period_to' => $this->faker->date,
            'hours' => $this->faker->numberBetween(1, 40),
            'type_of_ld' => $this->faker->word,
            'created_at' => $createdAt,
        ];
    }
}
