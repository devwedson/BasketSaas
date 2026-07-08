<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->string('opponent');
            $table->string('location')->nullable();
            $table->dateTime('scheduled_at');
            $table->unsignedSmallInteger('home_score')->nullable();
            $table->unsignedSmallInteger('away_score')->nullable();
            $table->boolean('is_home')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('game_lineups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_starter')->default(false);
            $table->timestamps();

            $table->unique(['game_id', 'player_id']);
        });

        Schema::create('game_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('minutes')->default(0);
            $table->unsignedSmallInteger('points')->default(0);
            $table->unsignedSmallInteger('rebounds')->default(0);
            $table->unsignedSmallInteger('assists')->default(0);
            $table->unsignedSmallInteger('steals')->default(0);
            $table->unsignedSmallInteger('blocks')->default(0);
            $table->unsignedSmallInteger('turnovers')->default(0);
            $table->unsignedSmallInteger('fouls')->default(0);
            $table->unsignedSmallInteger('fg_made')->default(0);
            $table->unsignedSmallInteger('fg_attempted')->default(0);
            $table->unsignedSmallInteger('three_made')->default(0);
            $table->unsignedSmallInteger('three_attempted')->default(0);
            $table->unsignedSmallInteger('ft_made')->default(0);
            $table->unsignedSmallInteger('ft_attempted')->default(0);
            $table->timestamps();

            $table->unique(['game_id', 'player_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_stats');
        Schema::dropIfExists('game_lineups');
        Schema::dropIfExists('games');
    }
};