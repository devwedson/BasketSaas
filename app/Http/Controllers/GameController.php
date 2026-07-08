<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\Game;
use App\Models\GameStat;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    use ScopesByClub;

    public function index(Request $request): View
    {
        $games = $this->scopeByClub(
            Game::query()->with(['team', 'club'])->orderBy('scheduled_at'),
            $request
        )->paginate(10);

        return view('games.index', compact('games'));
    }

    public function create(Request $request): View
    {
        return view('games.create', [
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Game::create($this->validatedData($request, attachFiles: true));

        return redirect()->route('games.index')->with('success', 'Jogo cadastrado com sucesso.');
    }

    public function show(Request $request, Game $game): View
    {
        $this->authorizeClubAccess($request, $game->club_id);
        $game->load(['team', 'club', 'stats.player', 'lineups.player']);

        $players = Player::query()
            ->where('club_id', $game->club_id)
            ->when($game->team_id, fn ($q) => $q->where('team_id', $game->team_id))
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('games.show', compact('game', 'players'));
    }

    public function edit(Request $request, Game $game): View
    {
        $this->authorizeClubAccess($request, $game->club_id);

        return view('games.edit', [
            'game' => $game,
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request, $game->club_id),
        ]);
    }

    public function update(Request $request, Game $game): RedirectResponse
    {
        $this->authorizeClubAccess($request, $game->club_id);
        $game->update($this->validatedData($request, $game, attachFiles: true));

        return redirect()->route('games.show', $game)->with('success', 'Jogo atualizado com sucesso.');
    }

    public function destroy(Request $request, Game $game): RedirectResponse
    {
        $this->authorizeClubAccess($request, $game->club_id);
        $game->delete();

        return redirect()->route('games.index')->with('success', 'Jogo removido com sucesso.');
    }

    public function stats(Request $request, Game $game): RedirectResponse
    {
        $this->authorizeClubAccess($request, $game->club_id);

        $data = $request->validate([
            'stats' => ['required', 'array'],
            'stats.*.minutes' => ['nullable', 'integer', 'min:0'],
            'stats.*.points' => ['nullable', 'integer', 'min:0'],
            'stats.*.rebounds' => ['nullable', 'integer', 'min:0'],
            'stats.*.assists' => ['nullable', 'integer', 'min:0'],
            'stats.*.steals' => ['nullable', 'integer', 'min:0'],
            'stats.*.blocks' => ['nullable', 'integer', 'min:0'],
            'stats.*.turnovers' => ['nullable', 'integer', 'min:0'],
            'stats.*.fouls' => ['nullable', 'integer', 'min:0'],
            'stats.*.fg_made' => ['nullable', 'integer', 'min:0'],
            'stats.*.fg_attempted' => ['nullable', 'integer', 'min:0'],
            'stats.*.three_made' => ['nullable', 'integer', 'min:0'],
            'stats.*.three_attempted' => ['nullable', 'integer', 'min:0'],
            'stats.*.ft_made' => ['nullable', 'integer', 'min:0'],
            'stats.*.ft_attempted' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($data['stats'] as $playerId => $stats) {
            GameStat::query()->updateOrCreate(
                ['game_id' => $game->id, 'player_id' => $playerId],
                array_map(fn ($v) => (int) ($v ?? 0), $stats)
            );
        }

        return redirect()->route('games.show', $game)->with('success', 'Estatísticas salvas com sucesso.');
    }

    private function validatedData(Request $request, ?Game $game = null, bool $attachFiles = false): array
    {
        $data = $request->validate([
            'club_id' => ['nullable', 'exists:clubs,id'],
            'team_id' => ['nullable', 'exists:teams,id'],
            'opponent' => ['required', 'string', 'max:255'],
            'opponent_logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'location' => ['nullable', 'string', 'max:255'],
            'scheduled_at' => ['required', 'date'],
            'home_score' => ['nullable', 'integer', 'min:0'],
            'away_score' => ['nullable', 'integer', 'min:0'],
            'is_home' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $clubId = $this->resolveClubId($request, $data['club_id'] ?? $game?->club_id);
        $this->authorizeClubAccess($request, $clubId);

        if (! empty($data['team_id'])) {
            $team = Team::query()->findOrFail($data['team_id']);
            abort_if($team->club_id !== $clubId, 422, 'Time não pertence ao clube.');
        }

        $payload = [
            'club_id' => $clubId,
            'team_id' => $data['team_id'] ?? null,
            'opponent' => $data['opponent'],
            'location' => $data['location'] ?? null,
            'scheduled_at' => $data['scheduled_at'],
            'home_score' => $data['home_score'] ?? null,
            'away_score' => $data['away_score'] ?? null,
            'is_home' => $request->boolean('is_home', true),
            'notes' => $data['notes'] ?? null,
        ];

        if ($attachFiles) {
            if ($request->hasFile('opponent_logo')) {
                $payload['opponent_logo'] = $request->file('opponent_logo')->store('games/opponent-logos', 'public');
            }

            if ($request->hasFile('cover_image')) {
                $payload['cover_image'] = $request->file('cover_image')->store('games/covers', 'public');
            }
        }

        return $payload;
    }

    private function teamsForForm(Request $request, ?int $clubId = null)
    {
        $query = Team::query()->where('is_active', true)->orderBy('name');

        if ($clubId) {
            $query->where('club_id', $clubId);
        } elseif (! $request->user()->isSuperAdmin()) {
            $query->where('club_id', $request->user()->club_id);
        }

        return $query->get();
    }
}