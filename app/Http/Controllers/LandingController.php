<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Services\LandingDataService;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __construct(private LandingDataService $landing) {}

    public function index(): View
    {
        $club = $this->landing->featuredClub();

        return view('landing.index', [
            'pageTitle' => 'Início',
            'currentRoute' => 'landing',
            'club' => $club,
            'stats' => $this->landing->stats($club),
            'teams' => $this->landing->teams($club, 4),
            'upcomingGames' => $this->landing->upcomingGames($club, 3),
            'featuredPlayers' => $this->landing->featuredPlayers($club, 4),
            'sponsors' => $this->landing->sponsors($club),
            'trainings' => $this->landing->trainings($club, 3),
            'recentGames' => $this->landing->recentGames($club, 3),
        ]);
    }

    public function about(): View
    {
        $club = $this->landing->featuredClub();

        return view('landing.about', [
            'pageTitle' => 'Sobre',
            'currentRoute' => 'landing.about',
            'club' => $club,
            'stats' => $this->landing->stats($club),
            'staff' => $this->landing->staff($club, 4),
        ]);
    }

    public function contact(): View
    {
        return view('landing.contact', [
            'pageTitle' => 'Contato',
            'currentRoute' => 'landing.contact',
            'club' => $this->landing->featuredClub(),
        ]);
    }

    public function programs(): View
    {
        $club = $this->landing->featuredClub();

        return view('landing.programs', [
            'pageTitle' => 'Programas',
            'currentRoute' => 'landing.programs',
            'club' => $club,
            'teams' => $this->landing->teams($club),
        ]);
    }

    public function matches(): View
    {
        $club = $this->landing->featuredClub();

        return view('landing.matches', [
            'pageTitle' => 'Jogos',
            'currentRoute' => 'landing.matches',
            'club' => $club,
            'upcomingGames' => $this->landing->upcomingGames($club),
            'recentGames' => $this->landing->recentGames($club),
        ]);
    }

    public function team(): View
    {
        $club = $this->landing->featuredClub();

        return view('landing.team', [
            'pageTitle' => 'Equipes',
            'currentRoute' => 'landing.team',
            'club' => $club,
            'teams' => $this->landing->teams($club, limit: null),
        ]);
    }

    public function teamShow(Team $team): View
    {
        $club = $this->landing->featuredClub();
        $team = $this->landing->teamForClub($club, $team);

        abort_if(! $team, 404);

        return view('landing.team-show', [
            'pageTitle' => $team->name,
            'currentRoute' => 'landing.team',
            'club' => $club,
            'team' => $team,
            'players' => $this->landing->playersForTeam($team),
            'staff' => $this->landing->staffForTeam($team),
        ]);
    }

    public function blog(): View
    {
        $club = $this->landing->featuredClub();

        return view('landing.blog', [
            'pageTitle' => 'Notícias',
            'currentRoute' => 'landing.blog',
            'club' => $club,
            'trainings' => $this->landing->trainings($club),
            'recentGames' => $this->landing->recentGames($club, 4),
        ]);
    }

    public function faqs(): View
    {
        return view('landing.faqs', [
            'pageTitle' => 'FAQ',
            'currentRoute' => 'landing.faqs',
            'club' => $this->landing->featuredClub(),
            'faqCategories' => config('landing.faqs', []),
        ]);
    }
}