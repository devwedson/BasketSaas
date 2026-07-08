<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\Game;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    use ScopesByClub;

    public function index(Request $request): View
    {
        $trainings = $this->scopeByClub(
            Training::query()->with('team')->where('scheduled_at', '>=', now()->subMonth()),
            $request
        )->orderBy('scheduled_at')->get();

        $games = $this->scopeByClub(
            Game::query()->with('team')->where('scheduled_at', '>=', now()->subMonth()),
            $request
        )->orderBy('scheduled_at')->get();

        $events = collect()
            ->merge($trainings->map(fn ($t) => [
                'type' => 'training',
                'title' => $t->title,
                'datetime' => $t->scheduled_at,
                'location' => $t->location,
                'team' => $t->team?->name,
                'url' => route('trainings.show', $t),
            ]))
            ->merge($games->map(fn ($g) => [
                'type' => 'game',
                'title' => 'vs '.$g->opponent,
                'datetime' => $g->scheduled_at,
                'location' => $g->location,
                'team' => $g->team?->name,
                'url' => route('games.show', $g),
            ]))
            ->sortBy('datetime')
            ->groupBy(fn ($e) => $e['datetime']->format('Y-m-d'));

        return view('calendar.index', compact('events'));
    }
}