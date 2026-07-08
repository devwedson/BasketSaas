<?php

namespace App\Http\Controllers;

use App\Exports\ClubsExport;
use App\Exports\GameStatsExport;
use App\Exports\GamesExport;
use App\Exports\PlayersExport;
use App\Exports\TeamsExport;
use App\Exports\TrainingsExport;
use App\Models\Game;
use App\Models\Team;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function __construct(private ReportService $reports) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $clubId = $this->reports->resolveClubId($user, $request->integer('club_id') ?: null);

        $teamsQuery = Team::query()->where('is_active', true)->orderBy('name');
        if ($clubId) {
            $teamsQuery->where('club_id', $clubId);
        } elseif (! $user->isSuperAdmin()) {
            $teamsQuery->where('club_id', $user->club_id);
        }

        $gamesQuery = Game::query()->orderByDesc('scheduled_at');
        if ($clubId) {
            $gamesQuery->where('club_id', $clubId);
        } elseif (! $user->isSuperAdmin()) {
            $gamesQuery->where('club_id', $user->club_id);
        }

        return view('reports.index', [
            'clubs' => $this->reports->clubs($user),
            'teams' => $teamsQuery->get(),
            'games' => $gamesQuery->limit(50)->get(),
            'selectedClubId' => $clubId,
        ]);
    }

    public function export(Request $request, string $type, string $format): Response|BinaryFileResponse
    {
        abort_unless(in_array($format, ['pdf', 'excel'], true), 404);

        $user = $request->user();
        $clubId = $this->reports->resolveClubId($user, $request->integer('club_id') ?: null);
        $teamId = $request->integer('team_id') ?: null;
        $gameId = $request->integer('game_id') ?: null;

        $meta = [
            'title' => $this->reportTitle($type),
            'generatedAt' => now()->format('d/m/Y H:i'),
            'user' => $user->name,
        ];

        return match ($type) {
            'clubs' => $this->exportClubs($user, $format, $meta),
            'players' => $this->exportPlayers($user, $format, $meta, $clubId, $teamId),
            'teams' => $this->exportTeams($user, $format, $meta, $clubId),
            'trainings' => $this->exportTrainings($user, $format, $meta, $clubId, $teamId),
            'games' => $this->exportGames($user, $format, $meta, $clubId, $teamId),
            'game-stats' => $this->exportGameStats($user, $format, $meta, $gameId),
            default => abort(404),
        };
    }

    private function exportClubs($user, string $format, array $meta): Response|BinaryFileResponse
    {
        abort_unless($user->isSuperAdmin(), 403);

        $clubs = $this->reports->clubs($user);
        $filename = 'clubes-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new ClubsExport($clubs), "{$filename}.xlsx");
        }

        return $this->pdf('reports.pdf.table', [
            'meta' => $meta,
            'headers' => ['Nome', 'Cidade', 'UF', 'E-mail', 'Telefone', 'Status'],
            'rows' => $clubs->map(fn ($c) => [
                $c->name, $c->city, $c->state, $c->email, $c->phone, $c->is_active ? 'Ativo' : 'Inativo',
            ]),
        ], $filename);
    }

    private function exportPlayers($user, string $format, array $meta, ?int $clubId, ?int $teamId): Response|BinaryFileResponse
    {
        $players = $this->reports->players($user, $clubId, $teamId);
        $filename = 'jogadores-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new PlayersExport($players), "{$filename}.xlsx");
        }

        return $this->pdf('reports.pdf.table', [
            'meta' => $meta,
            'headers' => ['Nome', 'Nº', 'Posição', 'Time', 'Clube', 'Status'],
            'rows' => $players->map(fn ($p) => [
                $p->name, $p->number, $p->position?->label(), $p->team?->name, $p->club->name, $p->is_active ? 'Ativo' : 'Inativo',
            ]),
        ], $filename);
    }

    private function exportTeams($user, string $format, array $meta, ?int $clubId): Response|BinaryFileResponse
    {
        $teams = $this->reports->teams($user, $clubId);
        $filename = 'times-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new TeamsExport($teams), "{$filename}.xlsx");
        }

        return $this->pdf('reports.pdf.table', [
            'meta' => $meta,
            'headers' => ['Nome', 'Categoria', 'Temporada', 'Clube', 'Status'],
            'rows' => $teams->map(fn ($t) => [
                $t->name, $t->category, $t->season?->name, $t->club->name, $t->is_active ? 'Ativo' : 'Inativo',
            ]),
        ], $filename);
    }

    private function exportTrainings($user, string $format, array $meta, ?int $clubId, ?int $teamId): Response|BinaryFileResponse
    {
        $trainings = $this->reports->trainings($user, $clubId, $teamId);
        $filename = 'treinos-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new TrainingsExport($trainings), "{$filename}.xlsx");
        }

        return $this->pdf('reports.pdf.table', [
            'meta' => $meta,
            'headers' => ['Título', 'Data/Hora', 'Local', 'Time', 'Clube'],
            'rows' => $trainings->map(fn ($t) => [
                $t->title, $t->scheduled_at->format('d/m/Y H:i'), $t->location, $t->team?->name, $t->club->name,
            ]),
        ], $filename);
    }

    private function exportGames($user, string $format, array $meta, ?int $clubId, ?int $teamId): Response|BinaryFileResponse
    {
        $games = $this->reports->games($user, $clubId, $teamId);
        $filename = 'jogos-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new GamesExport($games), "{$filename}.xlsx");
        }

        return $this->pdf('reports.pdf.table', [
            'meta' => $meta,
            'headers' => ['Adversário', 'Data/Hora', 'Local', 'Placar', 'Time', 'Mando'],
            'rows' => $games->map(fn ($g) => [
                $g->opponent,
                $g->scheduled_at->format('d/m/Y H:i'),
                $g->location,
                isset($g->home_score) ? $g->home_score.' x '.$g->away_score : '-',
                $g->team?->name,
                $g->is_home ? 'Casa' : 'Fora',
            ]),
        ], $filename);
    }

    private function exportGameStats($user, string $format, array $meta, ?int $gameId): Response|BinaryFileResponse
    {
        abort_unless($gameId, 422, 'Selecione um jogo.');

        ['game' => $game, 'stats' => $stats] = $this->reports->gameStats($user, $gameId);
        $meta['title'] = 'Estatísticas — vs '.$game->opponent;
        $meta['subtitle'] = $game->scheduled_at->format('d/m/Y H:i').' · '.$game->team?->name;

        $filename = 'estatisticas-jogo-'.$game->id.'-'.now()->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(new GameStatsExport($stats), "{$filename}.xlsx");
        }

        return $this->pdf('reports.pdf.game-stats', compact('meta', 'game', 'stats'), $filename);
    }

    private function pdf(string $view, array $data, string $filename): Response
    {
        return Pdf::loadView($view, $data)
            ->setPaper('a4', 'landscape')
            ->download("{$filename}.pdf");
    }

    private function reportTitle(string $type): string
    {
        return match ($type) {
            'clubs' => 'Relatório de Clubes',
            'players' => 'Relatório de Jogadores',
            'teams' => 'Relatório de Times',
            'trainings' => 'Relatório de Treinos',
            'games' => 'Relatório de Jogos',
            'game-stats' => 'Estatísticas do Jogo',
            default => 'Relatório',
        };
    }
}