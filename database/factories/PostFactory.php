<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => fake()->paragraphs(rand(1, 3), true),
            'code_snippet' => fake()->boolean(70) ? 
                "function example() {\n    " . fake()->text(100) . "\n}" : null,
            'likes_count' => 0, // Will be updated based on actual likes
            'comments_count' => 0, // Will be updated based on actual comments
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}