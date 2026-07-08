<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Injury extends Model
{
    protected $fillable = [
        'player_id',
        'description',
        'injury_date',
        'expected_return',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'injury_date' => 'date',
            'expected_return' => 'date',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}