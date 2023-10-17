<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'cards', 
        'turn'
    ];

    protected $casts = [
        'cards' => 'array'
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

}
