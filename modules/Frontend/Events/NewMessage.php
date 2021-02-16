<?php

namespace Modules\Frontend\Events;

use App\Models\Chats\Chat;
use App\Models\Chats\Message;
use App\Models\Client;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected Message $message;
    protected Chat $chat;
    protected Client $sender;

    public function __construct(Message $message, Chat $chat, Client $sender)
    {
        $this->message = $message;
        $this->chat = $chat;
        $this->sender = $sender;
    }

    public function broadcastOn(): PrivateChannel
    {
        $channel = $this->message->volunteer_id ? User::COMPANY : User::VOLUNTEER;
        $id = $channel === User::COMPANY ? $this->chat->company_id : $this->chat->volunteer_id;
        return new PrivateChannel("chat.$channel.$id");
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'sender' => $this->sender->append('name')
        ];
    }

    public function broadcastAs(): string
    {
        return 'chat.message.created';
    }
}
