<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        
        $posts = Post::all();

        $trendingTags = Hashtag::orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        return view('feed', compact('posts', 'user'));

    }
    }