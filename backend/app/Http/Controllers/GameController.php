<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use App\Models\Room;
use App\Models\Player;

use App\Http\Resources\PlayerRoomResource;

use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Requests\PlaceCardsRequest;
use App\Http\Requests\CallCardsRequest;

use App\Events\StartGameEvent;

use App\Events\PlaceCardsEvent;
use App\Events\CallCardsEvent;
use App\Events\EndGameEvent;

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
                
                $playerCount = $room->player_count;

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
                        'player_count' => $playerCount,
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

            return new PlayerRoomResource($player->loadMissing('user')->loadMissing('room'));
            
        } else {
            return $this->error('','You cannot be here', 403);

        }    
    }


    public function placeCards(PlaceCardsRequest $request){
        
        $request->validated($request->all());

        $room = Room::where('id', $request->id)->first();

        
        $gameEnded = $this->endGame($room->id);    
                

        if(!$gameEnded){
            
            $player = Player::where('room_id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->where('turn', $room->player_turn)->first()
            ->loadMissing('user');
            

            $lastCards = $request->cards;  

            $currentStack = $room->the_stack;

            foreach($lastCards as $card){
                array_push($currentStack, $card);
            }

            $nextPlayer = $room->player_turn + 1;

            $lastPlayer = $player->turn;

            if($nextPlayer > $room->player_count){
                $nextPlayer = 1;
                $lastPlayer = $room->player_count;
            }

            $turnCount = $room->turn_count + 1;

            $room->update([
                'last_cards' => $lastCards,
                'the_stack' => $currentStack,
                'player_turn' => $nextPlayer,
                'last_player' => $lastPlayer,
                'turn_value' => $request->value,
                'turn_count' => $turnCount,
            ]);

            $newCards = array_diff($player->cards, $lastCards);

            $player->update([
                'cards' => $newCards
            ]);

            $theNextPlayer = Player::where('room_id', $room->id)->where('turn', $nextPlayer)->first()->loadMissing('user');

            $playerResource = [
                'id' => $player->id,
                'name' => $player->user->name,
                'cards' => count($player->cards)
            ];         


            $nextPlayerResource = [
                'id' => $theNextPlayer->id,
                'name' => $theNextPlayer->user->name,
                'cards' => count($theNextPlayer->cards)
            ];         

            $turn = [
                'count' => $turnCount,
                'value' => $request->value
            ];


        
            event(new PlaceCardsEvent($room->id, $lastCards,
            $gameEnded, $playerResource, $nextPlayerResource, $turn));

            return $nextPlayerResource;
                
        } else{
            if(!$room){
                event(new PlaceCardsEvent(0, [],
                true, ['id'=>0, "name"=>"null", "cards"=>0 ],
                ['id'=>0, "name"=>"null", "cards"=>0 ],
                ['count'=>0, "value"=>0 ]
                ));
            }
            return $this->error('','You cannot place this card', 405);
        }

    }

    public function callCards(callCardsRequest $request){
        $request->validated($request->all());

        $room = Room::where('id', $request->id)->first();

        $lastPlayerId = $room->last_player;

        $gameEnded =  $this->endGame($request->id, true, $request->isTruth);

        $caller = Player::where('id', $request->callerId)->first();
        $lastPlayer = Player::where('room_id', $room->id)->where('turn', $room->last_player)->first()->loadMissing('user');
        
        $callerIsLastPlayer = $lastPlayer->id === $caller->id;

        

        if($room && $caller && $lastPlayer && !$callerIsLastPlayer && !$gameEnded){


            $theStack = $room->the_stack;

            $callerCards = $caller->cards;
            $lastPlayerCards = $lastPlayer->cards;

            $playerPickupId = ($request->isTruth) ? $caller->id : $lastPlayer->id; 

            $playerPickUp = Player::where('id', $playerPickupId)->first();
            $playerPickUpCards = $playerPickUp->cards;

            foreach($theStack as $card){
                array_push($playerPickUpCards, $card);
            }
            
            $newCards = array_merge($playerPickUpCards, $theStack);
            
            $playerPickUp->update([
                'cards'=>$playerPickUpCards
            ]);

            $room->update([
                'turn_count' => 0,
                'turn_value' => 3,
                'last_player' => null,
                'the_stack' => [],
                'last_cards' => []
            ]);

            event(new CallCardsEvent(
                $room->id, $playerPickupId,
                $caller->id, $gameEnded,
                $newCards
            ));

        } else {
            return $this->error('', 'You cannot call', 405);
        }
    }


    private function endGame($roomId, $onCall = false, $isTruth = false){
    
        $room = Room::where('id', $roomId)->first();

        $theLastPlayerId = $room->last_player;

        if(!$onCall){
            if($theLastPlayerId && $room){
                $theLastPlayer = Player::where('room_id', $room->id)
                ->where('turn', $theLastPlayerId)->first();
                
                $theLastPlayerCardCount = 0;
                
                foreach($theLastPlayer->cards as $card){
                    $theLastPlayerCardCount++;
                }

                $lastPlayerResource = [
                    'id' => $theLastPlayer->id,
                    'cards' => $theLastPlayerCardCount
                ];
    
                if($theLastPlayerCardCount < 1){
                    Player::where('room_id', $room->id)->delete();
                    $room->delete();
   
                    event(new EndGameEvent($roomId, true, $lastPlayerResource));

                    return true;
                }
            }
        } else if ($onCall && $isTruth){

            if($theLastPlayerId && $room){
            
                $theLastPlayer = Player::where('room_id', $room->id)
                ->where('turn', $theLastPlayerId)->first();
                
                $theLastPlayerCardCount = 0;
                
                foreach($theLastPlayer->cards as $card){
                    $theLastPlayerCardCount++;
                }

                $lastPlayerResource = [
                    'id' => $theLastPlayer->id,
                    'cards' => $theLastPlayerCardCount
                ];

                if($theLastPlayerCardCount < 1){
                    Player::where('room_id', $room->id)->delete();
                    $room->delete();

                    event(new EndGameEvent($roomId, true, $lastPlayerResource));

                    return true; 
                }
            }
        } else if(!$room){
            return true;
        }
        
        return false; 
    }

    private function getCards($allowJokers){
        
        return array_merge($this->normalCards, $this->jokers);
        if($allowJokers){
        }

        return $this->normalCards;

    }

    private function shuffleAndSpreadCards($cards, $roomId){ // Will shuffle and spread cards to players and assign turns 

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