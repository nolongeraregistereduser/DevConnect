<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewProfileController extends Controller
{
    /**
     * Display the user's public profile.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $isConnected = Auth::user()->connections()
            ->where('connected_user_id', $user->id)
            ->exists() || 
            $user->connections()
            ->where('connected_user_id', Auth::id())
            ->exists();

        return view('profile.view', compact('user', 'isConnected'));
    }

    /**
     * Display the authenticated user's own profile.
     */
    public function showOwn(Request $request)
    {
        return view('profile.view', [
            'user' => $request->user()
        ]);
    }
}