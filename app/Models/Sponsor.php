<?php

namespace App\Models;

use App\Enums\SponsorTier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sponsor extends Model
{
    protected $fillable = [
        'club_id',
        'name',
        'logo',
        'website',
        'contact_name',
        'contact_email',
        'contact_phone',
        'tier',
        'contract_amount',
        'starts_at',
        'ends_at',
        'sort_order',
        'show_on_landing',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'tier' => SponsorTier::class,
            'contract_amount' => 'decimal:2',
            'starts_at' => 'date',
            'ends_at' => 'date',
            'show_on_landing' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeVisibleOnLanding(Builder $query): Builder
    {
        return $query
            ->where('show_on_landing', true)
            ->where('is_active', true)
            ->where(function (Builder $query) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now()->toDateString());
            })
            ->where(function (Builder $query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', now()->toDateString());
            });
    }

    public function isContractActive(): bool
    {
        $today = now()->toDateString();

        if ($this->starts_at && $this->starts_at->toDateString() > $today) {
            return false;
        }

        if ($this->ends_at && $this->ends_at->toDateString() < $today) {
            return false;
        }

        return $this->is_active;
    }
}