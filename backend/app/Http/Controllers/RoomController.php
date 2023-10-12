<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Player;
use App\Models\PlayerUser;
use App\Models\PlayerRoom;

use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateRoomRequest;


$normalCards = [
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
    15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
    27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 
    39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
    51, 52 
];

$withJokers = array_merge($normalCards, [53, 54]);


class RoomController extends Controller
{
    private array $normalCards = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
        15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
        27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 
        39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
        51, 52 
    ];
    
    private array $jokers = [53, 54];
    
    use HttpResponse;

    public function createRoom(CreateRoomRequest $request){ // To create the game room

        $request->validated($request->all());

        $maxPlayerCount = $request->player_count;

        $allowJokers = $request->allow_jokers;

        $roomCode = random_int(100000, 999999);

        if($maxPlayerCount < 4){
            $allowJokers = true;
        }

        $theStack = ($allowJokers) ?  array_merge($this->normalCards, $this->jokers) : $this->normalCards ;

        $room = Room::create([
            'code' => $roomCode,
            'max_player_count' => $maxPlayerCount,
            'allow_jokers' => $allowJokers,
            'the_stack' => $theStack,
            'last_cards' => []
        
        ]);

        return $room;
    
    }


    public function addPlayer($roomId, $userId){ // To add a player to the game room
        
        $player = Player::create([ // 
        
        ]);

        $playerUser = PlayerUser::create([
            'user_id' => $userId,
            'player_id' => $player->id
        ]);

        $playerRoom = PlayerRoom::create([
            'room_id' => $roomId,
            'player_id' => $player->id
        ]);

                
    }
}