<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'code',
        'allow_jokers',
        'is_active',
        'max_player_count',
        'player_count',
        'player_turn',
        'turn_count',
        'turn_value',
        'last_player',
        'the_stack',
        'last_cards'
    ];

    protected $casts = [
        'the_stack' => 'array',
        'last_cards' => 'array'
    ];

    public function players(){

        return $this->hasMany(Player::class)->select('id', 'room_id', 'user_id', 'turn');
    } 

    
}
