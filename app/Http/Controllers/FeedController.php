<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $posts = Post::with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(10);

        $trendingTags = Hashtag::orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        
        return view('feed', compact('posts', 'user', 'trendingTags'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'code_snippet' => 'nullable|string',
        ]);

        $user = Auth::user();
        $post = $user->posts()->create([
            'content' => $validated['content'],
            'code_snippet' => $validated['code_snippet'],
        ]);

        // Extract hashtags from content
        preg_match_all('/#(\w+)/', $validated['content'], $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $tag) {
                $hashtag = Hashtag::firstOrCreate(['name' => $tag]);
                $post->hashtags()->attach($hashtag->id);
                $hashtag->increment('posts_count');
            }
        }

        return redirect()->route('feed')->with('success', 'Post created successfully!');
    }

    public function like(Post $post)
    {
        $user = Auth::user();

        if (!$post->isLikedBy($user)) {
            $post->likes()->create([
                'user_id' => $user->id
            ]);
            
            // Increment the likes count
            $post->increment('likes_count');
        }

        return response()->json([
            'success' => true,
            'likes_count' => $post->likes_count
        ]);
    }

    public function unlike(Post $post)
    {
        $user = Auth::user();

        if ($post->isLikedBy($user)) {
            $post->likes()->where('user_id', $user->id)->delete();
            
            // Decrement the likes count
            $post->decrement('likes_count');
        }

        return response()->json([
            'success' => true,
            'likes_count' => $post->likes_count
        ]);
    }
}
