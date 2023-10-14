<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



class RoomStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array

    {
        $players = PlayerResource::collection($this->whenLoaded('players')->loadMissing('user'));

        return [
            'player_amount' => count($this->whenLoaded('players')),
            parent::toArray($request),
            
        ];
    }

    protected function getPlayerAmount(){

    }
}
