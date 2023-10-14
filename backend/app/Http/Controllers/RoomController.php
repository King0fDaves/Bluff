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
use App\Http\Requests\AddPlayerRequest;

use App\Http\Resources\PlayerResource;
use App\Http\Resources\RoomStatsResource;

use App\Events\JoinRoomEvent;




$normalCards = [
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
    15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
    27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 
    39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
    51, 52,
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

    public function hostRoom(CreateRoomRequest $request){ // To create the game room

        $request->validated($request->all());

        $maxPlayerCount = $request->player_count;

        $allowJokers = $request->allow_jokers;

        $roomCode = $this->generateCode();

        if($maxPlayerCount < 4){
            $allowJokers = true;
        }

        $theStack = ($allowJokers) ?  array_merge($this->normalCards, $this->jokers) : $this->normalCards ;

        $room = Room::create([
            'code' => $roomCode,
            'max_player_count' => $maxPlayerCount,
            'allow_jokers' => $allowJokers, 
            'the_stack' => $theStack,
            'last_cards' => [],
            'player_count' => 1
        ]);


        
        $this->addPlayer($room->id, Auth::user()->id);
        
        return new RoomStatsResource($room->loadMissing('players'));
    }

    public function joinRoom(AddPlayerRequest $request){ // To allow a user to join a game room
        
        $request->validated($request->all());

        $room = Room::where('code', $request->code)->first();
        $roomPlayers = $room->loadMissing('players');

        $playerCount = count($roomPlayers->players);

        $foundPlayer = Player::where('user_id', Auth::user()->id)->where('room_id', $room->id)->first();

        if($room){
            if($playerCount < $room->max_player_count && !$room->is_active && !$foundPlayer){

                $this->addPlayer($room->id, Auth::user()->id);
        
                event(new JoinRoomEvent($room->id, Auth::user()->name));

                return $this->success(['room'=>$room->loadMissing('players')], 'You have joined');
                
            } else {
    
                return $this->error('', 'Cannot Join Room', 423);

            }

        } else {

            return $this->error('', 'Room Not Found', 404);
        
        }
        
    }


    private function addPlayer($roomId, $userId){ // To add a player to the game room
        
        $player = Player::create([ // 
            'user_id' => $userId,
            'room_id' => $roomId,
            'cards' => [1, 5, 19, 23, 54]
        ]);

    }

    private function generateCode(){ // To generate a room code
        $code = random_int(100000, 999999);

        $foundRoom = Room::where('code', $code)->exists();

        if($foundRoom){
            $this->generateCode();
        }

        return $code;
    }

}