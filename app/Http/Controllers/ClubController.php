<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClubController extends Controller
{
    public function index(): View
    {
        $clubs = Club::query()->latest()->paginate(10);

        return view('clubs.index', compact('clubs'));
    }

    public function create(): View
    {
        return view('clubs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:2'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'contact_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['slug'] = Str::slug($data['name']).'-'.Str::random(4);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clubs/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('clubs/covers', 'public');
        }

        if ($request->hasFile('contact_image')) {
            $data['contact_image'] = $request->file('contact_image')->store('clubs/contact', 'public');
        }

        Club::create($data);

        return redirect()
            ->route('clubs.index')
            ->with('success', 'Clube cadastrado com sucesso.');
    }

    public function show(Club $club): View
    {
        $club->loadCount(['teams', 'players', 'staff']);

        return view('clubs.show', compact('club'));
    }

    public function edit(Club $club): View
    {
        return view('clubs.edit', compact('club'));
    }

    public function update(Request $request, Club $club): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:2'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'contact_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clubs/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('clubs/covers', 'public');
        }

        if ($request->hasFile('contact_image')) {
            $data['contact_image'] = $request->file('contact_image')->store('clubs/contact', 'public');
        }

        $club->update($data);

        return redirect()
            ->route('clubs.show', $club)
            ->with('success', 'Clube atualizado com sucesso.');
    }

    public function destroy(Club $club): RedirectResponse
    {
        $club->delete();

        return redirect()
            ->route('clubs.index')
            ->with('success', 'Clube removido com sucesso.');
    }
}