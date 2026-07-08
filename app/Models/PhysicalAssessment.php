<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysicalAssessment extends Model
{
    protected $fillable = [
        'player_id',
        'assessed_at',
        'weight_kg',
        'height_cm',
        'vertical_jump_cm',
        'speed_ms',
        'endurance_notes',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'assessed_at' => 'date',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}