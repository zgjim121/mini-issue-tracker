<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'color' => $this->faker->optional(0.8)->hexColor(),
        ];
    }
}