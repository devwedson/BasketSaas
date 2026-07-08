<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InscriptionPayment extends Model
{
    protected $fillable = [
        'club_id',
        'staff_id',
        'user_id',
        'amount',
        'currency',
        'status',
        'gateway',
        'preference_id',
        'payment_id',
        'paid_at',
        'expires_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'status' => PaymentStatus::class,
            'paid_at' => 'datetime',
            'expires_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === PaymentStatus::Pending;
    }

    public function isPaid(): bool
    {
        return $this->status->isPaid();
    }

    public function isExpired(): bool
    {
        return $this->status === PaymentStatus::Expired
            || ($this->expires_at && $this->expires_at->isPast() && $this->isPending());
    }
}