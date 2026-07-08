<?php

namespace App\Models;

use App\Enums\StaffRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'club_id',
        'team_id',
        'user_id',
        'name',
        'email',
        'phone',
        'role',
        'photo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'role' => StaffRole::class,
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

    public function inscriptionPayments(): HasMany
    {
        return $this->hasMany(InscriptionPayment::class);
    }

    public function latestInscriptionPayment(): HasOne
    {
        return $this->hasOne(InscriptionPayment::class)->latestOfMany();
    }
}