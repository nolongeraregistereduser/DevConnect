<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '123456789', // password
            'bio' => fake()->paragraph(),
            'profile_picture' => null,
            'location' => fake()->city(),
            'website' => fake()->url(),
            'skills' => json_encode(fake()->randomElements(['PHP', 'Laravel', 'Vue.js', 'React', 'Node.js', 'Python', 'Java', 'Docker'], rand(3, 6))),
            'programming_languages' => json_encode(fake()->randomElements(['PHP', 'JavaScript', 'Python', 'Java', 'C++', 'Ruby'], rand(2, 4))),
            'projects' => json_encode(array_map(function() {
                return [
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'link' => fake()->url(),
                    'date' => fake()->date()
                ];
            }, range(1, rand(2, 5)))),
            'certifications' => json_encode(array_map(function() {
                return [
                    'title' => fake()->sentence(),
                    'organization' => fake()->company(),
                    'date' => fake()->date(),
                    'link' => fake()->url()
                ];
            }, range(1, rand(1, 3)))),
            'github_link' => 'https://github.com/' . fake()->userName(),
            'gitlab_link' => 'https://gitlab.com/' . fake()->userName(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
