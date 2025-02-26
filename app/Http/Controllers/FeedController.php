<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Hashtag;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'hashtags'])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

        $trendingTags = Hashtag::orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        return view('feed', compact('posts'));

    }
    }