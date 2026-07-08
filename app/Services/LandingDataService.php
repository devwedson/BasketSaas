<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Game;
use App\Models\Player;
use App\Models\Staff;
use App\Models\Team;
use App\Models\Training;
use Illuminate\Support\Collection;

class LandingDataService
{
    public function featuredClub(): ?Club
    {
        $slug = config('landing.featured_club_slug');

        if ($slug) {
            $club = Club::query()->where('slug', $slug)->where('is_active', true)->first();
            if ($club) {
                return $club;
            }
        }

        return Club::query()->where('is_active', true)->oldest()->first();
    }

    public function stats(?Club $club): array
    {
        if (! $club) {
            return [
                'players' => 0,
                'teams' => 0,
                'games' => 0,
                'staff' => 0,
            ];
        }

        return [
            'players' => Player::query()->where('club_id', $club->id)->where('is_active', true)->count(),
            'teams' => Team::query()->where('club_id', $club->id)->where('is_active', true)->count(),
            'games' => Game::query()->where('club_id', $club->id)->count(),
            'staff' => Staff::query()->where('club_id', $club->id)->where('is_active', true)->count(),
        ];
    }

    public function teams(?Club $club, int $limit = 8): Collection
    {
        if (! $club) {
            return collect();
        }

        return Team::query()
            ->where('club_id', $club->id)
            ->where('is_active', true)
            ->withCount('players')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    public function upcomingGames(?Club $club, int $limit = 6): Collection
    {
        if (! $club) {
            return collect();
        }

        return Game::query()
            ->where('club_id', $club->id)
            ->with('team')
            ->where('scheduled_at', '>=', now()->startOfDay())
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();
    }

    public function recentGames(?Club $club, int $limit = 6): Collection
    {
        if (! $club) {
            return collect();
        }

        return Game::query()
            ->where('club_id', $club->id)
            ->with('team')
            ->where(function ($query) {
                $query->where('scheduled_at', '<', now())
                    ->orWhereNotNull('home_score');
            })
            ->orderByDesc('scheduled_at')
            ->limit($limit)
            ->get();
    }

    public function allGames(?Club $club): Collection
    {
        if (! $club) {
            return collect();
        }

        return Game::query()
            ->where('club_id', $club->id)
            ->with('team')
            ->orderByDesc('scheduled_at')
            ->get();
    }

    public function players(?Club $club, int $limit = 12): Collection
    {
        if (! $club) {
            return collect();
        }

        return Player::query()
            ->where('club_id', $club->id)
            ->where('is_active', true)
            ->with('team')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    public function staff(?Club $club, int $limit = 8): Collection
    {
        if (! $club) {
            return collect();
        }

        return Staff::query()
            ->where('club_id', $club->id)
            ->where('is_active', true)
            ->with('team')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    public function trainings(?Club $club, int $limit = 6): Collection
    {
        if (! $club) {
            return collect();
        }

        return Training::query()
            ->where('club_id', $club->id)
            ->with('team')
            ->where('scheduled_at', '>=', now()->subDays(30))
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();
    }

    public function featuredPlayers(?Club $club, int $limit = 4): Collection
    {
        return $this->players($club, $limit);
    }
}