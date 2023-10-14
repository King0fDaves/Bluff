<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JoinRoomEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    private int $roomId;
    private string $username;
    /**
     * Create a new event instance.
     */
    public function __construct(int $roomId, string $username)
    {
        $this->roomId = $roomId;
        $this->username = $username;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('public.host');
    }

    public function broadcastAs()
    {
        return 'joined-room';
    }

    public function broadcastWith()
    {
        return [
            'roomId' => $this->roomId,
            'username' => $this->username
        ];
    }

    
}
