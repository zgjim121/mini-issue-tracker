<?php

namespace Database\Factories;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'issue_id' => Issue::factory(),
            'author_name' => $this->faker->name(),
            'body' => $this->faker->paragraphs(2, true),
        ];
    }
}