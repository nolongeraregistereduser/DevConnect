<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PostLiked extends Notification
{
    use Queueable;

    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'user_id' => $this->post->user_id,
            'message' => 'Your post has been liked!',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new DatabaseMessage($this->toDatabase($notifiable));
    }
}
