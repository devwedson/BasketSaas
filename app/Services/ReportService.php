<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Game;
use App\Models\GameStat;
use App\Models\Player;
use App\Models\Staff;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ReportService
{
    public function clubs(User $user): Collection
    {
        if ($user->isSuperAdmin()) {
            return Club::query()->orderBy('name')->get();
        }

        return Club::query()->where('id', $user->club_id)->get();
    }

    public function players(User $user, ?int $clubId = null, ?int $teamId = null): Collection
    {
        return $this->scopeByClub(Player::query()->with(['team', 'club']), $user, $clubId)
            ->when($teamId, fn (Builder $q) => $q->where('team_id', $teamId))
            ->orderBy('name')
            ->get();
    }

    public function teams(User $user, ?int $clubId = null): Collection
    {
        return $this->scopeByClub(Team::query()->with(['club', 'season']), $user, $clubId)
            ->orderBy('name')
            ->get();
    }

    public function staff(User $user, ?int $clubId = null, ?int $teamId = null): Collection
    {
        return $this->scopeByClub(Staff::query()->with(['team', 'club']), $user, $clubId)
            ->when($teamId, fn (Builder $q) => $q->where('team_id', $teamId))
            ->orderBy('name')
            ->get();
    }

    public function trainings(User $user, ?int $clubId = null, ?int $teamId = null): Collection
    {
        return $this->scopeByClub(Training::query()->with(['team', 'club']), $user, $clubId)
            ->when($teamId, fn (Builder $q) => $q->where('team_id', $teamId))
            ->orderBy('scheduled_at')
            ->get();
    }

    public function games(User $user, ?int $clubId = null, ?int $teamId = null): Collection
    {
        return $this->scopeByClub(Game::query()->with(['team', 'club']), $user, $clubId)
            ->when($teamId, fn (Builder $q) => $q->where('team_id', $teamId))
            ->orderBy('scheduled_at')
            ->get();
    }

    public function gameStats(User $user, int $gameId): array
    {
        $game = Game::query()->with(['team', 'club'])->findOrFail($gameId);
        $this->authorizeClub($user, $game->club_id);

        $stats = GameStat::query()
            ->with('player')
            ->where('game_id', $game->id)
            ->get()
            ->sortBy('player.name');

        return compact('game', 'stats');
    }

    public function resolveClubId(User $user, ?int $clubId): ?int
    {
        if ($user->isSuperAdmin()) {
            return $clubId;
        }

        return $user->club_id;
    }

    public function authorizeClub(User $user, int $clubId): void
    {
        if (! $user->isSuperAdmin() && $user->club_id !== $clubId) {
            abort(403);
        }
    }

    private function scopeByClub(Builder $query, User $user, ?int $clubId): Builder
    {
        if ($user->isSuperAdmin()) {
            if ($clubId) {
                $query->where('club_id', $clubId);
            }

            return $query;
        }

        return $query->where('club_id', $user->club_id);
    }
}