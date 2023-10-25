<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EndGameEvent implements Shouldbroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $roomId;
    private bool $gameEnded;
    private array $lastPlayer;

    /**
     * Create a new event instance.
     */
    public function __construct(int $roomId, bool $gameEnded, array $lastPlayer)
    {   
        $this->roomId = $roomId;
        $this->gameEnded = $gameEnded;
        $this->lastPlayer = $lastPlayer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel("presence.room.$this->roomId"),
        ];
    }

    public function broadcastAs()
    {
        return 'end-game';
    }

    public function broadcastWith()
    {
        return [
            'gameEnded' => $this->gameEnded,
            'lastPlayer' => $this->lastPlayer
        ];
    }
}
