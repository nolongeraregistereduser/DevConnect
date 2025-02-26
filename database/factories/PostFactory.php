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
            'content' => $this->faker->paragraph(),
            'code_snippet' => $this->faker->boolean(30) ? $this->faker->text() : null,
            'likes_count' => $this->faker->numberBetween(0, 100),
            'comments_count' => $this->faker->numberBetween(0, 50),
        ];
    }
}