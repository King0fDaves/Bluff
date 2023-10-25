<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Player;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('presence.room.{id}', function ($user, $id) {
    return checkPlayer($id, $user->id);
});

function checkPlayer($roomId, $userId){
    $player = Player::where('room_id', $roomId)->where('user_id', $userId)->first();

    if($player){
        return true;
    } else {
        return false;
    }

}
