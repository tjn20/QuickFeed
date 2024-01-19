<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

     public $user;
     public $message;
     public $conversation;
     public $receiver;
    public function __construct(User $user,User $receiver, Message $message,Conversation $conversation)
    {
        $this->user=$user;
        $this->message=$message;
        $this->conversation=$conversation;
        $this->receiver=$receiver;
    }

    public function broadcastWith(): array
    {
            return [
                'user_id'=>$this->user->id,
                'receiver_id'=>$this->receiver->id,
                'message'=>$this->message,
                'conversation_id'=>$this->conversation->id
            ];
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->receiver->id),
        ];
    }
}
