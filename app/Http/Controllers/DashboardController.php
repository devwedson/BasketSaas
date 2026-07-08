<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Club;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\Training;
use App\Services\StaffInscriptionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private StaffInscriptionService $inscriptions) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $clubId = $user->isSuperAdmin() ? null : $user->club_id;

        $stats = [
            'clubs' => $user->isSuperAdmin()
                ? Club::query()->count()
                : ($clubId ? Club::query()->where('id', $clubId)->count() : 0),
            'teams' => $this->countForClub(Team::query(), $clubId),
            'players' => $this->countForClub(Player::query()->where('is_active', true), $clubId),
            'trainings' => $this->countForClub(
                Training::query()->where('scheduled_at', '>=', now()),
                $clubId
            ),
            'games' => $this->countForClub(
                Game::query()->where('scheduled_at', '>=', now()),
                $clubId
            ),
        ];

        $upcomingTrainings = $this->scopedQuery(Training::query(), $clubId)
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();

        $upcomingGames = $this->scopedQuery(Game::query(), $clubId)
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();

        $inscriptionPayment = $user->hasRole(UserRole::Coach, UserRole::Assistant)
            ? $this->inscriptions->approvedPaymentForUser($user)
            : null;

        return view('dashboard.index', compact('stats', 'upcomingTrainings', 'upcomingGames', 'inscriptionPayment'));
    }

    private function countForClub($query, ?int $clubId): int
    {
        return $this->scopedQuery($query, $clubId)->count();
    }

    private function scopedQuery($query, ?int $clubId)
    {
        if ($clubId) {
            $query->where('club_id', $clubId);
        }

        return $query;
    }
}