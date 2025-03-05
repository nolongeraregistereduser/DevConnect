<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Events\TestNotification;
use App\Notifications\PostCreatedNotification;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ]);

        // Create the tweet
        $tweet = Tweet::create([
            'author' => $request->input('author'),
            'title' => $request->input('title'),
        ]);

        // Dispatch the event with the tweet data
        event(new TestNotification([
            'author' => $tweet->author,
            'title' => $tweet->title,
        ]));


     $user = User::find(Auth::id());
        $user->notify(new PostCreatedNotification($tweet));
        // Redirect with success message
        return redirect()->back()->with('success', 'Tweet created successfully!');
    }

    public function create()
    {
        return view('tweet');
    }
}