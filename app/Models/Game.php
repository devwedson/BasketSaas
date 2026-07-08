<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'club_id',
        'team_id',
        'opponent',
        'opponent_logo',
        'cover_image',
        'location',
        'scheduled_at',
        'home_score',
        'away_score',
        'is_home',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'is_home' => 'boolean',
        ];
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(GameStat::class);
    }

    public function lineups(): HasMany
    {
        return $this->hasMany(GameLineup::class);
    }
}