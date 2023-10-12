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
        'the_stack'
    ];

    protected $casts = [
        'the_stack' => 'array'
    ];

    public function players(): HasMany 
    {
        return $this->hasMany(Player::class, 'players_rooms'); 
    } 
}
