<?php

namespace App\Models;

use App\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        'club_id',
        'team_id',
        'user_id',
        'name',
        'email',
        'phone',
        'birth_date',
        'photo',
        'position',
        'number',
        'height_cm',
        'weight_kg',
        'guardian_name',
        'guardian_phone',
        'guardian_email',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'position' => PlayerPosition::class,
            'is_active' => 'boolean',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gameStats(): HasMany
    {
        return $this->hasMany(GameStat::class);
    }

    public function injuries(): HasMany
    {
        return $this->hasMany(Injury::class);
    }
}