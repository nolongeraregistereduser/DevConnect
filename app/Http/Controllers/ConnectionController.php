<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function store(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot connect with yourself');
        }

        $connection = Connection::firstOrCreate([
            'user_id' => Auth::id(),
            'connected_user_id' => $user->id
        ]);

        return back()->with('success', 'Connection request sent!');
    }
}