<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

     public $conversation_id;
     public $receiver_id;
     public $totalUnreadMessages;
    public function __construct($receiver_id,$conversation_id,$totalUnreadMessages)
    {
        $this->receiver_id=$receiver_id;
        $this->conversation_id=$conversation_id;
        $this->totalUnreadMessages=$totalUnreadMessages;
    }

    public function broadCastWith(): array
    {
            return [
                'conversation_id'=>$this->conversation_id,
                'receiver_id'=>$this->receiver_id,
                'totalUnreadMessages'=>$this->totalUnreadMessages
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
            new PrivateChannel('chat.'.$this->receiver_id),
        ];
    }
}
