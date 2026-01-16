<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Connection;
use App\Models\Hashtag;
use App\Models\Tweet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo users with realistic profiles
        $demoUsers = [
            [
                'name' => 'Sarah Chen',
                'email' => 'sarah.chen@devconnect.com',
                'password' => bcrypt('password'),
                'bio' => 'Full-stack developer passionate about Laravel and Vue.js. Building the future one commit at a time! 🚀',
                'location' => 'San Francisco, CA',
                'website' => 'https://sarahchen.dev',
                'skills' => ['Laravel', 'Vue.js', 'PHP', 'JavaScript', 'Docker', 'AWS'],
                'programming_languages' => ['PHP', 'JavaScript', 'Python'],
                'github_link' => 'https://github.com/sarahchen',
                'gitlab_link' => 'https://gitlab.com/sarahchen',
            ],
            [
                'name' => 'Alex Martinez',
                'email' => 'alex.martinez@devconnect.com',
                'password' => bcrypt('password'),
                'bio' => 'Backend engineer | Node.js enthusiast | Open source contributor',
                'location' => 'New York, NY',
                'website' => 'https://alexmartinez.dev',
                'skills' => ['Node.js', 'Express', 'MongoDB', 'TypeScript', 'GraphQL'],
                'programming_languages' => ['JavaScript', 'TypeScript', 'Go'],
                'github_link' => 'https://github.com/alexmartinez',
            ],
            [
                'name' => 'Emily Johnson',
                'email' => 'emily.j@devconnect.com',
                'password' => bcrypt('password'),
                'bio' => 'Frontend developer creating beautiful user experiences with React and Tailwind CSS',
                'location' => 'Austin, TX',
                'website' => 'https://emilyjohnson.dev',
                'skills' => ['React', 'Next.js', 'Tailwind CSS', 'TypeScript', 'Figma'],
                'programming_languages' => ['JavaScript', 'TypeScript'],
                'github_link' => 'https://github.com/emilyj',
            ],
            [
                'name' => 'Michael Park',
                'email' => 'michael.park@devconnect.com',
                'password' => bcrypt('password'),
                'bio' => 'DevOps engineer | Kubernetes | CI/CD | Cloud infrastructure',
                'location' => 'Seattle, WA',
                'website' => 'https://michaelpark.io',
                'skills' => ['Kubernetes', 'Docker', 'AWS', 'Terraform', 'Python'],
                'programming_languages' => ['Python', 'Bash', 'Go'],
                'github_link' => 'https://github.com/michaelpark',
            ],
        ];

        $createdUsers = collect();
        foreach ($demoUsers as $demoUser) {
            // Ensure password is hashed
            $demoUser['password'] = Hash::make($demoUser['password']);
            // Ensure JSON fields are properly encoded
            if (isset($demoUser['skills']) && is_array($demoUser['skills'])) {
                $demoUser['skills'] = json_encode($demoUser['skills']);
            }
            if (isset($demoUser['programming_languages']) && is_array($demoUser['programming_languages'])) {
                $demoUser['programming_languages'] = json_encode($demoUser['programming_languages']);
            }
            $createdUsers->push(User::factory()->create($demoUser));
        }

        // Create additional random users
        $randomUsers = User::factory(8)->create();
        $allUsers = $createdUsers->merge($randomUsers);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'bio' => 'Platform administrator for DevConnect. Always here to help! 👋',
            'location' => 'Remote',
            'skills' => ['Laravel', 'PHP', 'System Administration'],
            'programming_languages' => ['PHP', 'JavaScript'],
        ]);

        $allUsers->push($admin);

        // Create hashtags
        $hashtags = collect([
            'laravel', 'php', 'javascript', 'react', 'vuejs', 'nodejs', 'python',
            'webdev', 'coding', 'programming', 'opensource', 'docker', 'kubernetes',
            'aws', 'devops', 'frontend', 'backend', 'fullstack', 'tailwindcss',
            'typescript', 'mongodb', 'mysql', 'postgresql', 'api', 'rest', 'graphql'
        ])->map(function ($name) {
            return Hashtag::firstOrCreate(['name' => $name]);
        });

        // Create realistic posts with code snippets and hashtags
        $postContents = [
            [
                'content' => 'Just finished building a real-time notification system using Laravel Echo and Pusher! The implementation turned out to be much cleaner than I expected. #laravel #realtime #pusher',
                'code_snippet' => "window.Echo.channel('notifications')\n    .listen('NotificationCreated', (e) => {\n        console.log('New notification:', e);\n    });"
            ],
            [
                'content' => 'Spent the weekend learning React Server Components. Game changer for performance! Who else is excited about this? #react #nextjs #webdev',
                'code_snippet' => "async function ServerComponent() {\n    const data = await fetch('...');\n    return <div>{data.title}</div>;\n}"
            ],
            [
                'content' => 'Deployed my first Kubernetes cluster today! The learning curve is steep but totally worth it. #kubernetes #devops #cloud',
            ],
            [
                'content' => 'Working on a new feature for our app: real-time collaboration using WebSockets. The UX improvements are incredible! #websockets #realtime #ux',
                'code_snippet' => "const ws = new WebSocket('ws://localhost:8080');\nws.onmessage = (event) => {\n    updateCollaboration(event.data);\n};"
            ],
            [
                'content' => 'Just released v2.0 of my open-source project! Thanks to everyone who contributed. Check it out: https://github.com/example/project #opensource #release',
            ],
            [
                'content' => 'Optimized our database queries today. Reduced page load time by 60%! Performance optimization is such a satisfying part of development. #performance #optimization #mysql',
            ],
            [
                'content' => 'Building a REST API with Laravel. The resource controllers make everything so clean and organized. #laravel #php #api #rest',
                'code_snippet' => "Route::apiResource('posts', PostController::class);\n// Auto-generates all CRUD routes!"
            ],
            [
                'content' => 'Tailwind CSS 4.0 looks amazing! The new features are going to make styling so much faster. #tailwindcss #css #frontend',
            ],
        ];

        // Create posts for each user
        $allUsers->each(function ($user) use ($allUsers, $postContents, $hashtags) {
            // Create 3-8 posts per user
            $userPostCount = rand(3, 8);
            
            for ($i = 0; $i < $userPostCount; $i++) {
                $postData = $postContents[array_rand($postContents)];
                
                $post = Post::factory()->create([
                    'user_id' => $user->id,
                    'content' => $postData['content'],
                    'code_snippet' => $postData['code_snippet'] ?? null,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);

                // Attach 2-4 random hashtags to each post
                $hashtagCount = min(rand(2, 4), $hashtags->count());
                $postHashtags = $hashtags->random($hashtagCount);
                $post->hashtags()->attach($postHashtags->pluck('id'));

                // Create comments (2-8 per post)
                $commentCount = rand(2, 8);
                for ($j = 0; $j < $commentCount; $j++) {
                    Comment::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $allUsers->where('id', '!=', $user->id)->random()->id,
                        'content' => fake()->paragraph(),
                        'created_at' => $post->created_at->addMinutes(rand(5, 1440)),
                    ]);
                }

                // Create likes (5-25 per post)
                $availableUsers = $allUsers->where('id', '!=', $user->id);
                $likeCount = min(rand(5, 25), $availableUsers->count());
                $likeUsers = $availableUsers->random($likeCount);
                foreach ($likeUsers as $likeUser) {
                    Like::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $likeUser->id,
                        'created_at' => $post->created_at->addMinutes(rand(1, 720)),
                    ]);
                }

                // Update counts
                $post->update([
                    'likes_count' => $post->likes()->count(),
                    'comments_count' => $post->comments()->count(),
                ]);
            }
        });

        // Create connections (pending, accepted)
        $allUsers->each(function ($user) use ($allUsers) {
            // Each user has 2-5 accepted connections
            $availableUsers = $allUsers->where('id', '!=', $user->id);
            $acceptedCount = min(rand(2, 5), $availableUsers->count());
            $acceptedUsers = $availableUsers->random($acceptedCount);
            
            foreach ($acceptedUsers as $connectedUser) {
                // Check if connection doesn't already exist
                if (!Connection::where(function($q) use ($user, $connectedUser) {
                    $q->where('user_id', $user->id)->where('connected_user_id', $connectedUser->id);
                })->orWhere(function($q) use ($user, $connectedUser) {
                    $q->where('user_id', $connectedUser->id)->where('connected_user_id', $user->id);
                })->exists()) {
                    Connection::create([
                        'user_id' => $user->id,
                        'connected_user_id' => $connectedUser->id,
                        'status' => 'accepted',
                        'created_at' => now()->subDays(rand(1, 60)),
                    ]);
                }
            }

            // Each user has 1-3 pending connection requests (sent by them)
            $remainingUsers = $allUsers->where('id', '!=', $user->id)
                ->reject(function($u) use ($acceptedUsers) {
                    return $acceptedUsers->contains('id', $u->id);
                });
            $pendingCount = min(rand(1, 3), $remainingUsers->count());
            $pendingUsers = $remainingUsers->random($pendingCount);
            
            foreach ($pendingUsers as $pendingUser) {
                if (!Connection::where(function($q) use ($user, $pendingUser) {
                    $q->where('user_id', $user->id)->where('connected_user_id', $pendingUser->id);
                })->orWhere(function($q) use ($user, $pendingUser) {
                    $q->where('user_id', $pendingUser->id)->where('connected_user_id', $user->id);
                })->exists()) {
                    Connection::create([
                        'user_id' => $user->id,
                        'connected_user_id' => $pendingUser->id,
                        'status' => 'pending',
                        'created_at' => now()->subDays(rand(1, 7)),
                    ]);
                }
            }
        });

        // Create some tweets
        $tweetTitles = [
            'Laravel 11 Released!',
            'New React Features Coming Soon',
            'Vue 3.4 Performance Improvements',
            'Docker Best Practices Guide',
            'Kubernetes Deployment Strategies',
            'AWS Lambda Optimization Tips',
            'TypeScript 5.0 Highlights',
            'Tailwind CSS 4.0 Beta',
        ];

        foreach ($tweetTitles as $title) {
            Tweet::create([
                'author' => $allUsers->random()->name,
                'title' => $title,
                'created_at' => now()->subDays(rand(0, 14)),
            ]);
        }
    }
}
