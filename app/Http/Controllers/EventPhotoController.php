<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\EventPhoto;
use App\Services\LandingDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventPhotoController extends Controller
{
    public function index(): View
    {
        $eventPhotos = EventPhoto::query()
            ->with('club')
            ->orderByDesc('event_date')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('event-photos.index', compact('eventPhotos'));
    }

    public function create(LandingDataService $landing): View
    {
        return view('event-photos.create', [
            'clubs' => $this->clubsForSelect(),
            'defaultClubId' => $landing->featuredClub()?->id,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $data['image'] = store_panel_upload($request->file('image'), 'events/photos');

        EventPhoto::query()->create($data);

        return redirect()
            ->route('event-photos.index')
            ->with('success', 'Foto do evento publicada com sucesso.');
    }

    public function show(EventPhoto $eventPhoto): View
    {
        $eventPhoto->load('club');

        return view('event-photos.show', compact('eventPhoto'));
    }

    public function edit(EventPhoto $eventPhoto): View
    {
        return view('event-photos.edit', [
            'eventPhoto' => $eventPhoto,
            'clubs' => $this->clubsForSelect(),
        ]);
    }

    public function update(Request $request, EventPhoto $eventPhoto): RedirectResponse
    {
        $data = $this->validatedData($request, $eventPhoto);

        if ($request->hasFile('image')) {
            $data['image'] = store_panel_upload($request->file('image'), 'events/photos');
        }

        $eventPhoto->update($data);

        return redirect()
            ->route('event-photos.show', $eventPhoto)
            ->with('success', 'Foto do evento atualizada com sucesso.');
    }

    public function destroy(EventPhoto $eventPhoto): RedirectResponse
    {
        $eventPhoto->delete();

        return redirect()
            ->route('event-photos.index')
            ->with('success', 'Foto do evento removida com sucesso.');
    }

    private function validatedData(Request $request, ?EventPhoto $eventPhoto = null): array
    {
        $data = $request->validate([
            'club_id' => ['required', 'exists:clubs,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => [$eventPhoto ? 'nullable' : 'required', 'image', 'max:5120'],
            'event_date' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active', $eventPhoto?->is_active ?? true);

        return $data;
    }

    private function clubsForSelect()
    {
        return Club::query()->where('is_active', true)->orderBy('name')->get();
    }
}