<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    use ScopesByClub;

    public function index(Request $request): View
    {
        $teams = $this->scopeByClub(
            Team::query()->with(['club', 'season'])->latest(),
            $request
        )->get();

        return view('teams.index', compact('teams'));
    }

    public function create(Request $request): View
    {
        return view('teams.create', [
            'clubs' => $this->clubsForSelect($request),
            'seasons' => $this->seasonsForForm($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'club_id' => ['nullable', 'exists:clubs,id'],
            'season_id' => ['nullable', 'exists:seasons,id'],
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'uniform_description' => ['nullable', 'string'],
        ]);

        $payload = [
            'club_id' => $this->resolveClubId($request, $data['club_id'] ?? null),
            'season_id' => $data['season_id'] ?? null,
            'name' => $data['name'],
            'category' => $data['category'] ?? null,
            'description' => $data['description'] ?? null,
            'uniform_description' => $data['uniform_description'] ?? null,
        ];

        if ($request->hasFile('logo')) {
            $payload['logo'] = $request->file('logo')->store('teams/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $payload['cover_image'] = $request->file('cover_image')->store('teams/covers', 'public');
        }

        Team::create($payload);

        return redirect()->route('teams.index')->with('success', 'Time cadastrado com sucesso.');
    }

    public function show(Request $request, Team $team): View
    {
        $this->authorizeClubAccess($request, $team->club_id);
        $team->load(['club', 'season'])->loadCount(['players', 'staff', 'trainings', 'games']);

        return view('teams.show', compact('team'));
    }

    public function edit(Request $request, Team $team): View
    {
        $this->authorizeClubAccess($request, $team->club_id);

        return view('teams.edit', [
            'team' => $team,
            'clubs' => $this->clubsForSelect($request),
            'seasons' => $this->seasonsForForm($request, $team->club_id),
        ]);
    }

    public function update(Request $request, Team $team): RedirectResponse
    {
        $this->authorizeClubAccess($request, $team->club_id);

        $data = $request->validate([
            'season_id' => ['nullable', 'exists:seasons,id'],
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'uniform_description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'season_id' => $data['season_id'] ?? null,
            'name' => $data['name'],
            'category' => $data['category'] ?? null,
            'description' => $data['description'] ?? null,
            'uniform_description' => $data['uniform_description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('logo')) {
            $payload['logo'] = $request->file('logo')->store('teams/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $payload['cover_image'] = $request->file('cover_image')->store('teams/covers', 'public');
        }

        $team->update($payload);

        return redirect()->route('teams.show', $team)->with('success', 'Time atualizado com sucesso.');
    }

    public function destroy(Request $request, Team $team): RedirectResponse
    {
        $this->authorizeClubAccess($request, $team->club_id);
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Time removido com sucesso.');
    }

    private function seasonsForForm(Request $request, ?int $clubId = null)
    {
        $query = Season::query()->orderByDesc('is_current')->orderByDesc('start_date');

        if ($clubId) {
            $query->where('club_id', $clubId);
        } elseif (! $request->user()->isSuperAdmin()) {
            $query->where('club_id', $request->user()->club_id);
        }

        return $query->get();
    }
}