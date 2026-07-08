<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameLineup extends Model
{
    protected $fillable = [
        'game_id',
        'player_id',
        'is_starter',
    ];

    protected function casts(): array
    {
        return [
            'is_starter' => 'boolean',
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}