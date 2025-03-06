<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use App\Notifications\ConnectionRequest;
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
            'connected_user_id' => $user->id,
            'status' => 'pending'
        ]);

        // Send notification to the receiver (connected_user)
        $user->notify(new ConnectionRequest($connection));

        return back()->with('success', 'Connection request sent!');
    }

    public function accept(Connection $connection)
    {
        if ($connection->connected_user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $connection->update(['status' => 'accepted']);

        return back()->with('success', 'Connection request accepted!');
    }

    public function reject(Connection $connection)
    {
        if ($connection->connected_user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $connection->update(['status' => 'rejected']);

        return back()->with('success', 'Connection request rejected!');
    }
}