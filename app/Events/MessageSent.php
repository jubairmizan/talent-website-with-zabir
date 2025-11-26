<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public Message $message;
    public int $conversationId;

    public function __construct(Message $message, Conversation $conversation)
    {
        $this->message = $message;
        $this->conversationId = $conversation->id;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('conversation.' . $this->conversationId);
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        $sender = $this->message->sender;

        return [
            'message' => [
                'id' => $this->message->id,
                'message' => $this->message->message,
                'sender_id' => $this->message->sender_id,
                'sender_name' => $sender->name ?? 'Unknown User',
                'sender_avatar' => $sender->avatar ?? null,
                'is_own_message' => false,
                'is_read' => (bool) $this->message->is_read,
                'created_at' => $this->message->created_at?->toISOString(),
                'formatted_time' => $this->message->created_at?->format('H:i'),
            ],
        ];
    }
}

