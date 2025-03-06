<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Get only notifications for the currently authenticated user
        $user = Auth::user();
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        // Ensure the notification belongs to the current user
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();
            
        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        // Only mark notifications for the current user
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    }
}