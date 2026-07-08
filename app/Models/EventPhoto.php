<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventPhoto extends Model
{
    protected $fillable = [
        'club_id',
        'title',
        'description',
        'image',
        'event_date',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
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

    public function scopeForLanding(Builder $query): Builder
    {
        return $query->active()->orderByDesc('event_date')->orderBy('sort_order')->orderByDesc('id');
    }
}