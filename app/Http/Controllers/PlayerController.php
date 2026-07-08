<?php

namespace App\Http\Controllers;

use App\Enums\PlayerPosition;
use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlayerController extends Controller
{
    use ScopesByClub;

    public function index(Request $request): View
    {
        $players = $this->scopeByClub(
            Player::query()->with(['team', 'club'])->latest(),
            $request
        )->get();

        return view('players.index', compact('players'));
    }

    public function create(Request $request): View
    {
        return view('players.create', [
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request),
            'positions' => PlayerPosition::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('players/photos', 'public');
        }

        Player::create($data);

        return redirect()->route('players.index')->with('success', 'Jogador cadastrado com sucesso.');
    }

    public function show(Request $request, Player $player): View
    {
        $this->authorizeClubAccess($request, $player->club_id);
        $player->load(['team', 'club']);

        return view('players.show', compact('player'));
    }

    public function edit(Request $request, Player $player): View
    {
        $this->authorizeClubAccess($request, $player->club_id);

        return view('players.edit', [
            'player' => $player,
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request, $player->club_id),
            'positions' => PlayerPosition::cases(),
        ]);
    }

    public function update(Request $request, Player $player): RedirectResponse
    {
        $this->authorizeClubAccess($request, $player->club_id);

        $data = $this->validatedData($request, $player);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('players/photos', 'public');
        }

        $player->update($data);

        return redirect()->route('players.show', $player)->with('success', 'Jogador atualizado com sucesso.');
    }

    public function destroy(Request $request, Player $player): RedirectResponse
    {
        $this->authorizeClubAccess($request, $player->club_id);
        $player->delete();

        return redirect()->route('players.index')->with('success', 'Jogador removido com sucesso.');
    }

    private function validatedData(Request $request, ?Player $player = null): array
    {
        $data = $request->validate([
            'club_id' => ['nullable', 'exists:clubs,id'],
            'team_id' => ['nullable', 'exists:teams,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'birth_date' => ['nullable', 'date'],
            'position' => ['nullable', Rule::enum(PlayerPosition::class)],
            'number' => ['nullable', 'integer', 'min:0', 'max:99'],
            'height_cm' => ['nullable', 'numeric', 'min:0'],
            'weight_kg' => ['nullable', 'numeric', 'min:0'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:30'],
            'guardian_email' => ['nullable', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $clubId = $this->resolveClubId($request, $data['club_id'] ?? $player?->club_id);
        $this->authorizeClubAccess($request, $clubId);

        if (! empty($data['team_id'])) {
            $team = Team::query()->findOrFail($data['team_id']);
            abort_if($team->club_id !== $clubId, 422, 'Time não pertence ao clube.');
        }

        return [
            'club_id' => $clubId,
            'team_id' => $data['team_id'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'position' => $data['position'] ?? null,
            'number' => $data['number'] ?? null,
            'height_cm' => $data['height_cm'] ?? null,
            'weight_kg' => $data['weight_kg'] ?? null,
            'guardian_name' => $data['guardian_name'] ?? null,
            'guardian_phone' => $data['guardian_phone'] ?? null,
            'guardian_email' => $data['guardian_email'] ?? null,
            'is_active' => $request->boolean('is_active', $player?->is_active ?? true),
        ];
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