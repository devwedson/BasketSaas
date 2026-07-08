<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Club;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait ScopesByClub
{
    protected function scopeByClub(Builder $query, Request $request): Builder
    {
        $user = $request->user();

        if (! $user->isSuperAdmin()) {
            $query->where('club_id', $user->club_id);
        }

        return $query;
    }

    protected function resolveClubId(Request $request, ?int $clubId = null): int
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            abort_if(! $clubId, 422, 'Selecione um clube.');

            return $clubId;
        }

        abort_if(! $user->club_id, 403, 'Usuário sem clube vinculado.');

        return $user->club_id;
    }

    protected function authorizeClubAccess(Request $request, int $clubId): void
    {
        if (! $request->user()->isSuperAdmin() && $request->user()->club_id !== $clubId) {
            abort(403);
        }
    }

    protected function clubsForSelect(Request $request)
    {
        if ($request->user()->isSuperAdmin()) {
            return Club::query()->where('is_active', true)->orderBy('name')->get();
        }

        return Club::query()
            ->where('id', $request->user()->club_id)
            ->get();
    }
}