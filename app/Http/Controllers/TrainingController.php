<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\Player;
use App\Models\Team;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingController extends Controller
{
    use ScopesByClub;

    public function index(Request $request): View
    {
        $trainings = $this->scopeByClub(
            Training::query()->with(['team', 'club'])->orderBy('scheduled_at'),
            $request
        )->get();

        return view('trainings.index', compact('trainings'));
    }

    public function create(Request $request): View
    {
        return view('trainings.create', [
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        Training::create($data);

        return redirect()->route('trainings.index')->with('success', 'Treino agendado com sucesso.');
    }

    public function show(Request $request, Training $training): View
    {
        $this->authorizeClubAccess($request, $training->club_id);
        $training->load(['team', 'club', 'attendance.player']);

        $players = Player::query()
            ->where('club_id', $training->club_id)
            ->when($training->team_id, fn ($q) => $q->where('team_id', $training->team_id))
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('trainings.show', compact('training', 'players'));
    }

    public function edit(Request $request, Training $training): View
    {
        $this->authorizeClubAccess($request, $training->club_id);

        return view('trainings.edit', [
            'training' => $training,
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request, $training->club_id),
        ]);
    }

    public function update(Request $request, Training $training): RedirectResponse
    {
        $this->authorizeClubAccess($request, $training->club_id);
        $training->update($this->validatedData($request, $training));

        return redirect()->route('trainings.show', $training)->with('success', 'Treino atualizado com sucesso.');
    }

    public function destroy(Request $request, Training $training): RedirectResponse
    {
        $this->authorizeClubAccess($request, $training->club_id);
        $training->delete();

        return redirect()->route('trainings.index')->with('success', 'Treino removido com sucesso.');
    }

    public function attendance(Request $request, Training $training): RedirectResponse
    {
        $this->authorizeClubAccess($request, $training->club_id);

        $data = $request->validate([
            'attendance' => ['nullable', 'array'],
            'attendance.*' => ['boolean'],
            'notes' => ['nullable', 'array'],
            'notes.*' => ['nullable', 'string'],
        ]);

        $playerIds = Player::query()
            ->where('club_id', $training->club_id)
            ->pluck('id');

        foreach ($playerIds as $playerId) {
            TrainingAttendance::query()->updateOrCreate(
                ['training_id' => $training->id, 'player_id' => $playerId],
                [
                    'present' => isset($data['attendance'][$playerId]),
                    'notes' => $data['notes'][$playerId] ?? null,
                ]
            );
        }

        return redirect()->route('trainings.show', $training)->with('success', 'Presença registrada com sucesso.');
    }

    private function validatedData(Request $request, ?Training $training = null): array
    {
        $data = $request->validate([
            'club_id' => ['nullable', 'exists:clubs,id'],
            'team_id' => ['nullable', 'exists:teams,id'],
            'title' => ['required', 'string', 'max:255'],
            'scheduled_at' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'exercises' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $clubId = $this->resolveClubId($request, $data['club_id'] ?? $training?->club_id);
        $this->authorizeClubAccess($request, $clubId);

        if (! empty($data['team_id'])) {
            $team = Team::query()->findOrFail($data['team_id']);
            abort_if($team->club_id !== $clubId, 422, 'Time não pertence ao clube.');
        }

        return [
            'club_id' => $clubId,
            'team_id' => $data['team_id'] ?? null,
            'title' => $data['title'],
            'scheduled_at' => $data['scheduled_at'],
            'location' => $data['location'] ?? null,
            'exercises' => $data['exercises'] ?? null,
            'notes' => $data['notes'] ?? null,
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