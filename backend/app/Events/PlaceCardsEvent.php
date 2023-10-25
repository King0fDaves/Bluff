<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlaceCardsEvent implements Shouldbroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $roomId;
    private array $lastCards;
    private bool $gameEnded;
    private array $lastPlayer;
    private array $currentPlayer;
    private array $turn;

    /**
     * Create a new event instance.
     */
    
    public function __construct( int $roomId, array $lastCards, 
        bool $gameEnded, array $lastPlayer, array $currentPlayer,
        array $turn
    )


    {      
        $this->roomId = $roomId;
        $this->lastCards = $lastCards;
        $this->gameEnded = $gameEnded;
        $this->lastPlayer = $lastPlayer;
        $this->currentPlayer = $currentPlayer;
        $this->turn = $turn;
        
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
        return 'place-cards';
    }

    public function broadcastWith()
    {
        return [
            'roomId' => $this->roomId,
            'lastCards' => $this->lastCards,
            'gameEnded' => $this->gameEnded,    
            'lastPlayer' => $this->lastPlayer,
            'currentPlayer' => $this->currentPlayer,
            'turn' => $this->turn
        ];
    }



}
