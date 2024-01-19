<?php

namespace App\Events;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FeedPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

     public $user;
     public $feed;
    public function __construct(User $user,Feed $feed)
    {
    $this->user=$user;
    $this->feed=$feed;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadCastWith(): array
    {        

        return [
            'user_id'=>$this->user->id,
            'feed_id'=>$this->feed->id
        ];
        
    }

    


    public function broadcastOn(): array
    {
        
       
        return [
        new Channel('feeds')
       ]; 

    }
}
