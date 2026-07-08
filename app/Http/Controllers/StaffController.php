<?php

namespace App\Http\Controllers;

use App\Enums\StaffRole;
use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\Staff;
use App\Models\Team;
use App\Services\StaffInscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StaffController extends Controller
{
    use ScopesByClub;

    public function __construct(private StaffInscriptionService $inscriptions) {}

    public function index(Request $request): View
    {
        $staffMembers = $this->scopeByClub(
            Staff::query()->with(['team', 'club', 'latestInscriptionPayment'])->latest(),
            $request
        )->get();

        return view('staff.index', [
            'staffMembers' => $staffMembers,
            'inscriptionEnabled' => $this->inscriptions->shouldChargeInscription(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('staff.create', [
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request),
            'roles' => StaffRole::cases(),
            'inscriptionEnabled' => $this->inscriptions->shouldChargeInscription(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = store_panel_upload($request->file('photo'), 'staff/photos');
        }

        $staff = Staff::create($data);

        return $this->redirectAfterSave(
            $request,
            $staff,
            'Membro da comissão cadastrado com sucesso.'
        );
    }

    public function show(Request $request, Staff $staff): View
    {
        $this->authorizeClubAccess($request, $staff->club_id);
        $staff->load(['team', 'club', 'user', 'latestInscriptionPayment']);

        return view('staff.show', [
            'staff' => $staff,
            'inscriptionEnabled' => $this->inscriptions->shouldChargeInscription(),
        ]);
    }

    public function edit(Request $request, Staff $staff): View
    {
        $this->authorizeClubAccess($request, $staff->club_id);

        return view('staff.edit', [
            'staff' => $staff,
            'clubs' => $this->clubsForSelect($request),
            'teams' => $this->teamsForForm($request, $staff->club_id),
            'roles' => StaffRole::cases(),
            'inscriptionEnabled' => $this->inscriptions->shouldChargeInscription(),
        ]);
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorizeClubAccess($request, $staff->club_id);

        $data = $this->validatedData($request, $staff);

        if ($request->hasFile('photo')) {
            $data['photo'] = store_panel_upload($request->file('photo'), 'staff/photos');
        }

        $staff->update($data);

        return $this->redirectAfterSave(
            $request,
            $staff,
            'Membro da comissão atualizado com sucesso.',
            route('staff.show', $staff)
        );
    }

    public function provisionAccess(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorizeClubAccess($request, $staff->club_id);

        $result = $this->inscriptions->provisionAccess($staff, forceNewPayment: true);

        $message = 'Acesso e cobrança de inscrição gerados com sucesso.';

        if (! empty($result['plain_password'])) {
            $message .= ' Senha temporária: '.$result['plain_password'];
        }

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', $message);
    }

    public function destroy(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorizeClubAccess($request, $staff->club_id);
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Membro da comissão removido com sucesso.');
    }

    private function redirectAfterSave(
        Request $request,
        Staff $staff,
        string $baseMessage,
        ?string $redirectTo = null
    ): RedirectResponse {
        $message = $baseMessage;

        if ($request->boolean('create_panel_access')) {
            $result = $this->inscriptions->provisionAccess($staff);
            $message .= ' Acesso ao painel criado com cobrança de inscrição pendente.';

            if (! empty($result['plain_password'])) {
                $message .= ' Senha temporária: '.$result['plain_password'];
            }
        }

        return redirect()
            ->to($redirectTo ?? route('staff.index'))
            ->with('success', $message);
    }

    private function validatedData(Request $request, ?Staff $staff = null): array
    {
        $data = $request->validate([
            'club_id' => ['nullable', 'exists:clubs,id'],
            'team_id' => ['nullable', 'exists:teams,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                Rule::requiredIf($request->boolean('create_panel_access')),
                'nullable',
                'email',
                'max:255',
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::enum(StaffRole::class)],
            'photo' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'create_panel_access' => ['nullable', 'boolean'],
        ]);

        $clubId = $this->resolveClubId($request, $data['club_id'] ?? $staff?->club_id);
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
            'role' => $data['role'],
            'is_active' => $request->boolean('is_active', $staff?->is_active ?? true),
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