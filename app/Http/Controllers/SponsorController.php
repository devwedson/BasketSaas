<?php

namespace App\Http\Controllers;

use App\Enums\SponsorTier;
use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\FinancialTransaction;
use App\Models\Sponsor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SponsorController extends Controller
{
    use ScopesByClub;

    public function index(Request $request): View
    {
        $sponsors = $this->scopeByClub(
            Sponsor::query()->with('club')->orderBy('sort_order')->orderBy('name'),
            $request
        )->paginate(10);

        return view('sponsors.index', compact('sponsors'));
    }

    public function create(Request $request): View
    {
        return view('sponsors.create', [
            'clubs' => $this->clubsForSelect($request),
            'tiers' => SponsorTier::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sponsors/logos', 'public');
        }

        $sponsor = Sponsor::create($data);

        $this->syncFinancialRecord($request, $sponsor);

        return redirect()->route('sponsors.index')->with('success', 'Patrocinador cadastrado com sucesso.');
    }

    public function show(Request $request, Sponsor $sponsor): View
    {
        $this->authorizeClubAccess($request, $sponsor->club_id);
        $sponsor->load('club');

        return view('sponsors.show', compact('sponsor'));
    }

    public function edit(Request $request, Sponsor $sponsor): View
    {
        $this->authorizeClubAccess($request, $sponsor->club_id);

        return view('sponsors.edit', [
            'sponsor' => $sponsor,
            'clubs' => $this->clubsForSelect($request),
            'tiers' => SponsorTier::cases(),
        ]);
    }

    public function update(Request $request, Sponsor $sponsor): RedirectResponse
    {
        $this->authorizeClubAccess($request, $sponsor->club_id);

        $data = $this->validatedData($request, $sponsor);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sponsors/logos', 'public');
        }

        $sponsor->update($data);

        $this->syncFinancialRecord($request, $sponsor);

        return redirect()->route('sponsors.show', $sponsor)->with('success', 'Patrocinador atualizado com sucesso.');
    }

    public function destroy(Request $request, Sponsor $sponsor): RedirectResponse
    {
        $this->authorizeClubAccess($request, $sponsor->club_id);
        $sponsor->delete();

        return redirect()->route('sponsors.index')->with('success', 'Patrocinador removido com sucesso.');
    }

    private function validatedData(Request $request, ?Sponsor $sponsor = null): array
    {
        $data = $request->validate([
            'club_id' => ['nullable', 'exists:clubs,id'],
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'tier' => ['required', Rule::enum(SponsorTier::class)],
            'contract_amount' => ['nullable', 'numeric', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'show_on_landing' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
            'record_financial' => ['nullable', 'boolean'],
        ]);

        $clubId = $this->resolveClubId($request, $data['club_id'] ?? $sponsor?->club_id);
        $this->authorizeClubAccess($request, $clubId);

        $tier = SponsorTier::from($data['tier']);

        return [
            'club_id' => $clubId,
            'name' => $data['name'],
            'website' => $data['website'] ?? null,
            'contact_name' => $data['contact_name'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'tier' => $tier,
            'contract_amount' => $data['contract_amount'] ?? null,
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'sort_order' => $data['sort_order'] ?? ($tier->sortWeight() * 10),
            'show_on_landing' => $request->boolean('show_on_landing', $sponsor?->show_on_landing ?? true),
            'is_active' => $request->boolean('is_active', $sponsor?->is_active ?? true),
            'notes' => $data['notes'] ?? null,
        ];
    }

    private function syncFinancialRecord(Request $request, Sponsor $sponsor): void
    {
        if (! $request->boolean('record_financial') || ! $sponsor->contract_amount) {
            return;
        }

        FinancialTransaction::query()->updateOrCreate(
            [
                'club_id' => $sponsor->club_id,
                'category' => 'patrocinio',
                'description' => 'Patrocínio: '.$sponsor->name,
            ],
            [
                'type' => 'income',
                'amount' => $sponsor->contract_amount,
                'transaction_date' => $sponsor->starts_at ?? now()->toDateString(),
            ]
        );
    }
}