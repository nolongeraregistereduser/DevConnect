<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'github_link' => ['nullable', 'url', 'max:255'],
            'skills' => ['nullable', 'string'],
            'programming_languages' => ['nullable', 'string'],
            'projects' => ['nullable', 'string'], // For JSON data
            'certifications' => ['nullable', 'string'], // For JSON data
            'profile_picture' => ['nullable', 'image'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        // Parse JSON strings back to arrays
        $skills = json_decode($request->skills, true) ?? [];
        $programming_languages = json_decode($request->programming_languages, true) ?? [];
        $projects = json_decode($request->projects, true) ?? [];
        $certifications = json_decode($request->certifications, true) ?? [];

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bio' => $validated['bio'],
            'location' => $validated['location'],
            'website' => $validated['website'],
            'github_link' => $validated['github_link'],
            'skills' => $skills,
            'programming_languages' => $programming_languages,
            'projects' => $projects,
            'certifications' => $certifications,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('feed');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
