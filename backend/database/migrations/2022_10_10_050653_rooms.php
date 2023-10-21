<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {    
            $table->id();
            $table->integer('creator_id');
            $table->string('code');
            $table->integer('player_count')->default(0);
            $table->integer('max_player_count');
            $table->boolean('allow_jokers')->default(true);
             
            $table->integer('turn_count')->default(0);
            $table->integer('turn_value')->default(3);
            $table->integer('player_turn')->default(1);
            $table->integer('last_player')->nullable()->default(null);

            $table->boolean('is_active')->default(false);

            $table->json('the_stack')->default(0);
            $table->json('last_cards')->default(0);      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');

    }
};
