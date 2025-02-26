<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ViewProfileController extends Controller
{
    /**
     * Display the user's public profile.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return view('profile.view', [
            'user' => $user
        ]);
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