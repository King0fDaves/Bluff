<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Player;



class PlayerRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    
    public function toArray(Request $request): array
    {
       $room = $this->whenLoaded('room');

       $canCall =  $this->checkIfCanCall($room);
       
       $lastPlayer = $this->getLastPlayer($room);
       
       $currentPlayer = Player::where('room_id', $room->id)->where('turn', $room->player_turn)->first();

        return [
            'id' => $this->id,
            'cards' => $this->cards,
            'turn' => $this->turn,

            'lastPlayer' => $lastPlayer,

            'currentPlayer' => [
                'id' => $currentPlayer->id,
                'name' => $currentPlayer->loadMissing('user')->user->name,
                'cards' => count($currentPlayer->cards)
            ],
            'user' => $this->whenLoaded('user'),
            'room' => $this->whenLoaded('room'),
        ];
    }

    private function checkIfCanCall($room){
 
        $turnCount = $room->turn_count;

        if($turnCount > 0){
            return true;
        } 

        return false;
    }

    private function getLastPlayer($room){

        $player = Player::where('room_id', $room->id)->where('turn', $room->last_player)->first(); 

        if($player){
            return [
                'canCall' => true,
                'id'=> $player->id,
                'name' => $player->loadMissing('user')->user->name,
                'cards' => count($player->cards)
            ];
        }
    
        return [
            'canCall' => false,
            'name' => null,
            'cards' => null
        ];

    }
}

