<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'allow_jokers',
        'max_player_count',
        'the_stack',
        'last_cards'
    ];

    protected $casts = [
        'the_stack' => 'array',
        'last_cards' => 'array'
    ];

    public function players(){

        return $this->hasMany(Player::class); 
    } 
}
