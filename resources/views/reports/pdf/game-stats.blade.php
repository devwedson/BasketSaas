<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>{{ $meta['title'] }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #333; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { font-size: 10px; color: #666; margin-bottom: 16px; }
        .score { font-size: 22px; font-weight: bold; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #3e60d5; color: #fff; padding: 6px 4px; text-align: center; font-size: 9px; }
        td { padding: 5px 4px; border-bottom: 1px solid #e5e7eb; text-align: center; }
        td:first-child { text-align: left; }
        tr:nth-child(even) td { background: #f9fafb; }
    </style>
</head>
<body>
    <h1>{{ $meta['title'] }}</h1>
    <div class="meta">
        {{ $meta['subtitle'] ?? '' }} · {{ config('app.name') }} · {{ $meta['generatedAt'] }}
    </div>

    @if (isset($game->home_score))
        <div class="score">Placar: {{ $game->home_score }} x {{ $game->away_score }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Jogador</th>
                <th>MIN</th><th>PTS</th><th>REB</th><th>AST</th>
                <th>ROU</th><th>TOC</th><th>TO</th><th>FLT</th>
                <th>FG</th><th>3PT</th><th>FT</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stats as $stat)
                <tr>
                    <td>{{ $stat->player->name }}</td>
                    <td>{{ $stat->minutes }}</td>
                    <td>{{ $stat->points }}</td>
                    <td>{{ $stat->rebounds }}</td>
                    <td>{{ $stat->assists }}</td>
                    <td>{{ $stat->steals }}</td>
                    <td>{{ $stat->blocks }}</td>
                    <td>{{ $stat->turnovers }}</td>
                    <td>{{ $stat->fouls }}</td>
                    <td>{{ $stat->fg_made }}/{{ $stat->fg_attempted }}</td>
                    <td>{{ $stat->three_made }}/{{ $stat->three_attempted }}</td>
                    <td>{{ $stat->ft_made }}/{{ $stat->ft_attempted }}</td>
                </tr>
            @empty
                <tr><td colspan="12" style="text-align:center;padding:20px;">Nenhuma estatística registrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>