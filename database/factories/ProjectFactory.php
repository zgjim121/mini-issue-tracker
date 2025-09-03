<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
        
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraphs(2, true),
            'start_date' => $startDate,
            'deadline' => $this->faker->optional(0.7)->dateTimeBetween($startDate, '+6 months'),
        ];
    }
}