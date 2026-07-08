<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClubSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        $club = $this->clubForUser($request);

        return view('club-settings.edit', compact('club'));
    }

    public function update(Request $request): RedirectResponse
    {
        $club = $this->clubForUser($request);

        $data = $request->validate([
            'description' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:2'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'contact_image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = store_panel_upload($request->file('logo'), 'clubs/logos');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = store_panel_upload($request->file('cover_image'), 'clubs/covers');
        }

        if ($request->hasFile('contact_image')) {
            $data['contact_image'] = store_panel_upload($request->file('contact_image'), 'clubs/contact');
        }

        $club->update($data);

        return redirect()
            ->route('club.settings.edit')
            ->with('success', 'Configurações da landing atualizadas com sucesso.');
    }

    private function clubForUser(Request $request): Club
    {
        $club = $request->user()->club;

        abort_unless($club, 403, 'Usuário sem clube vinculado.');

        return $club;
    }
}