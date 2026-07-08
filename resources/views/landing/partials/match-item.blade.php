@php
    $itemIndex = $index ?? 0;
    $isPast = $game->scheduled_at->isPast() && $game->home_score !== null;
    $label = $isPast ? 'Resultado' : 'Próximo Jogo';
    $dateText = $game->scheduled_at->translatedFormat('d M Y').' '.($game->location ?? '');
    if ($isPast) {
        $dateText .= ' — '.$game->home_score.' x '.$game->away_score;
    }
@endphp

<div class="our-match-item">
    <div class="our-match-item-title">
        <h3>{{ $label }}</h3>
    </div>

    <div class="our-match-item-body">
        <div class="match-team-logo">
            <figure>
                <img src="{{ team_logo_url($game->team, 'images/team-logo-'.(($itemIndex % 6) + 1).'.png') }}" alt="{{ $game->team?->name ?? config('landing.brand.name') }}">
            </figure>
        </div>
        <div class="match-team-logo">
            <figure>
                <img src="{{ game_opponent_logo_url($game, 'images/team-logo-'.((($itemIndex + 1) % 6) + 1).'.png') }}" alt="{{ $game->opponent }}">
            </figure>
        </div>
    </div>

    <div class="our-match-item-date">
        <h3>{{ $dateText }}</h3>
    </div>

    <div class="our-match-item-btn">
        <a href="{{ route('landing.matches') }}">{{ $isPast ? 'Ver Resultados' : 'Ver Calendário' }}</a>
    </div>
</div>