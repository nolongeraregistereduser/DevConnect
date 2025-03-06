<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Connection;

class ConnectionRequest extends Notification
{
    use Queueable;

    public $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function via(object $notifiable): array
    {
        // Only send notification to the user receiving the connection request
        if ($notifiable->id === $this->connection->user_id) {
            return [];
        }
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $sender = User::find($this->connection->user_id);
        return [
            'connection_id' => $this->connection->id,
            'message' => 'You have received a connection request from ' . $sender->name,
            'sender_id' => $this->connection->user_id,
            'sender_name' => $sender->name
        ];
    }
}
