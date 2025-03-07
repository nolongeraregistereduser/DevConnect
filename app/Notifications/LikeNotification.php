<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Post;

class LikeNotification extends Notification
{
    use Queueable;

    protected $liker;
    // protected $post;

    /**
     * Create a new notification instance.
     */
    // public function __construct(User $liker, Post $post)
    public function __construct(User $liker)
    {
        $this->liker = $liker;
        // $this->post = $post;

        Log::info('LikeNotification constructed', [
            'liker_id' => $liker->id,
            // 'post_id' => $post->id
        ]);
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        Log::info('LikeNotification via method called', [
            'notifiable_id' => $notifiable->id
        ]);

        return ['App\Notifications\Channels\DirectDatabaseChannel', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $data = [
            'message' => $this->liker->name . ' liked your post',
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->name,
            // 'post_id' => $this->post->id,
            // 'url' => route('posts.show', $this->post->id)
        ];

        Log::info('LikeNotification toArray called', $data);

        return $data;
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $data = $this->toArray($notifiable);

        Log::info('LikeNotification toBroadcast called', [
            'notifiable_id' => $notifiable->id
        ]);

        return new BroadcastMessage([
            'id' => $this->id,
            'type' => get_class($this),
            'data' => $data,
            'created_at' => now()->toIso8601String()
        ]);
    }
}

