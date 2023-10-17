<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Player;

use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\AddPlayerRequest;
use App\Http\Requests\RoomRequest;


use App\Http\Resources\PlayerResource;
use App\Http\Resources\RoomStatsResource;

use App\Events\JoinRoomEvent;
use App\Events\LeaveRoomEvent;
use App\Events\RemoveRoomEvent;

class RoomController extends Controller
{
    
    use HttpResponse;

    public function hostRoom(CreateRoomRequest $request){ // To create the game room

        $request->validated($request->all());

        $maxPlayerCount = $request->player_count;

        $allowJokers = $request->allow_jokers;

        $roomCode = $this->generateCode();

        if($maxPlayerCount < 4){
            $allowJokers = true;
        }
        
        
        $room = Room::create([
            'creator_id' => Auth::user()->id,
            'code' => $roomCode,
            'max_player_count' => $maxPlayerCount,
            'allow_jokers' => $allowJokers, 
            'the_stack' => [],
            'last_cards' => [],
            'player_count' => 1
        ]);

        
        $this->addPlayer($room->id, Auth::user()->id);
        
        return new RoomStatsResource($room->loadMissing('players'));
    }

    public function joinRoom(AddPlayerRequest $request){ // To allow a user to join a game room
        
        $request->validated($request->all());

        $room = Room::where('code', $request->code)->first();
    
        if($room){

            $foundPlayer = Player::where('user_id', Auth::user()->id)->where('room_id', $room->id)->first();

            $roomPlayers = $room->loadMissing('players');

            $playerCount = count($roomPlayers->players);

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

    public function leaveRoom(RoomRequest $request){ // When a user decides to leave a room

        $request->validated($request->all());

        $player = Player::where('room_id', $request->id)
        ->where('user_id', Auth::user()->id)->first();

        if($player){

            event(new LeaveRoomEvent($request->id, Auth::user()->name));

            $player->delete();

            return $this->success('', 'You have left the room');
            
        } else {
            return $this->error('', 'Player Not Found', 404);
        }

    }

    public function removeRoom(RoomRequest $request){ // To delete the room created by the host

        $room = Room::where('id', $request->id)->where('creator_id', Auth::user()->id)->first();
        $players = Player::where('room_id', $request->id);
        
        if($room){

            event(new RemoveRoomEvent($room->id));

            $players->delete();
            $room->delete();
            
            return $this->success('', 'Room has been removed');

        } else {
            return $this->error('', 'You did not host this room', 403);
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