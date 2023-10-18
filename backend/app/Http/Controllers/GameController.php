<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use App\Models\Room;
use App\Models\Player;

use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;

use App\Events\StartGameEvent;

class GameController extends Controller
{
    private array $normalCards = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
        15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
        27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 
        39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50,
        51, 52 
    ];
    
    private array $jokers = [53, 54];

    private array $finalCards;

    private array $cardDistribution;
    private int $cardDistIndex = 0;
    private int $cardStart = 0;
    private int $cardIndex;
    private int $turnIndex = 0;
    private array $playerTurns = [];

    use HttpResponse;

    public function startGame(RoomRequest $request){
        
        $request->validated($request->all());
        $room = Room::where('id', $request->id)->first();    

        if($room){

            if($room->creator_id === Auth::user()->id){
                
                $roomPlayers = $room->loadMissing('players');
                $playerCount = count($roomPlayers->players);

                if($playerCount > 2){

                    $allowJokers = $room->allow_jokers;

                    if($playerCount < 4){
                        $allowJokers = true;
                    }
                    
                    $this->finalCards = $this->getCards($allowJokers);

                    $this->shuffleAndSpreadCards($this->finalCards, $request->id);

                    $room->update([
                        'is_active' => true,
                        'allow_jokers' => $allowJokers,
                    ]);

                    event(new StartGameEvent($room->id));

                    return $this->success('Room has been created');
                    
                } else {
                    return $this->error('', 'Room needs more players', 405);
                }
            
            } else {

                return $this->error('', 'You are not the Host', 403);
            }
           
        } else {
            return $this->error('', 'Room Not Found', 404);
        }

    }

    
    public function getPlayer(RoomRequest $request){
    
        $player = Player::where('room_id', $request->id)->where('user_id', Auth::user()->id);

        if($player){

            $player = $player->first();
            $room = Player::where('room_id', $request->id)->first();

            $playerInfo = [
                'id' => $player->id,
                'roomId' => $player->room_id,
                'userId' => $player->user_id,
                'cards' => $player->cards,
                'turn' => $player->turn,
                'currentTurn' => [
                    'player' => $room->player_turn,
                    'card_count' => $room->turn_count,
                    'card_value' => $room->turn_value
                ],
                'theStack' => $room->the_stack,
                'last_cards' => $room->last_cards

            ];
    
            return $this->success($playerInfo, 'You can be here');
        }

        return $this->error('You cannot be here', 403);
    
    }

    private function getCards($allowJokers){
        
        if($allowJokers){
            return array_merge($this->normalCards, $this->jokers);
        }

        return $this->normalCards;

    }

    private function shuffleAndSpreadCards($cards, $roomId){ // Will shuffle and spread cards to players and assign turns 

        shuffle($this->finalCards);

        shuffle($this->finalCards);

        shuffle($this->finalCards);

        $players = Player::where('room_id', $roomId);

        $totalPlayerCount = count($players->get()->toArray());

        $cardCount = count($cards);

        $this->cardDistribution = $this->getCardDistribution($cardCount, $totalPlayerCount);
    
        $thePlayers = $players->get();

        for($index = 0; $index < $totalPlayerCount; $index++){ 
            array_push($this->playerTurns, $index+1);
        }

        shuffle($this->playerTurns);


        foreach ($thePlayers as $player){
            $player->cards = $this->addCards();    
            $player->turn = $this->playerTurns[$this->turnIndex];        
            $player->save();
            $this->turnIndex++;
        }
    }

    private function addCards(){

        $cardEnd = $this->cardDistribution[0];

        $playerCards = array_slice($this->finalCards, $this->cardStart, $cardEnd);

        $this->cardStart += $cardEnd;

        array_shift($this->cardDistribution);      

        return $playerCards;
    }

    private function getCardDistribution($cardCount, $playerCount){

        $cardDistribution = [];

        $remainders = $cardCount % $playerCount;
        
        $cardShare = $cardCount / $playerCount;

        if($remainders > 0){
            $cardShare = ($cardCount - $remainders) / $playerCount;
        }
        
        for($share = 0; $share < $playerCount; $share++){
            array_push($cardDistribution, $cardShare);
        }

        if($remainders > 0){

            for($index = 0; $index < $remainders; $index++){
                
                $cardDistribution[$index]++;
            
            }
        }   

        return $cardDistribution;
    }

}