<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallCardsEvent implements Shouldbroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private int $roomId;
    private int $playerPickupId;
    private int $callerId;
    private bool $gameEnded;
    private array $theStack;

    /**
     * Create a new event instance.
     */
    
    public function __construct( int $roomId, int $playerPickupId, int $callerId,
    bool $gameEnded, array $theStack)

    {      
        $this->roomId = $roomId;
        $this->playerPickupId = $playerPickupId;
        $this->callerId = $callerId;
        $this->gameEnded = $gameEnded;
        $this->theStack = $theStack;
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
        return 'call-cards';
    }

    public function broadcastWith()
    {
        return [
            'roomId' => $this->roomId,
            'playerPickUpId' => $this->playerPickupId,
            'theStack' => $this->theStack,
            'callerId' => $this->callerId,
            'gameEnded' => $this->gameEnded,    
        
        ];
    }
}
