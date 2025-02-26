<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 users
        $users = User::factory(10)->create();

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create posts for each user
        $users->each(function ($user) use ($users) {
            // Create 5-15 posts per user
            Post::factory(rand(5, 15))->create([
                'user_id' => $user->id
            ])->each(function ($post) use ($users) {
                // Create 0-8 comments per post
                Comment::factory(rand(0, 8))->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);

                // Create 0-20 likes per post
                $likeUsers = $users->random(rand(0, min(20, $users->count())))->pluck('id');
                foreach ($likeUsers as $userId) {
                    Like::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $userId,
                    ]);
                }

                // Update counts
                $post->update([
                    'likes_count' => $post->likes()->count(),
                    'comments_count' => $post->comments()->count(),
                ]);
            });
        });
    }
}
