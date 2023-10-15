<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeaveRoomEvent implements ShouldBroadcast
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
    public function broadcastOn(): array
    {
        return [
            new Channel('public.host'),
        ];
    }

    public function broadcastAs()
    {
        return 'leave-room';
    }

    public function broadcastWith()
    {
        return [
            'roomId' => $this->roomId,
            'user' => $this->username
        ];
    }

}
