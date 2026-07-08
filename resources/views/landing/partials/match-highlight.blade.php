<div class="match-highlight-item wow fadeInUp" @if(!empty($delay)) data-wow-delay="{{ $delay }}" @endif>
    <div class="match-highlight-image-box">
        <div class="match-highlight-item-image">
            <a href="{{ route('landing.matches') }}" data-cursor-text="Ver">
                <figure>
                    <img src="{{ game_cover_image_url($game, $index ?? 0) }}" alt="{{ $game->team?->name }} vs {{ $game->opponent }}">
                </figure>
            </a>
        </div>
        <div class="video-play-button">
            <a href="{{ route('landing.matches') }}">
                <img src="{{ neodunk_asset('images/icon-link.svg') }}" alt="">
            </a>
        </div>
    </div>
    <div class="match-highlight-item-body">
        <div class="match-highlight-item-meta">
            <ul>
                <li>{{ $game->scheduled_at->translatedFormat('d M Y') }}</li>
                <li><a href="{{ route('landing.matches') }}">Jogos</a></li>
            </ul>
        </div>
        <div class="match-highlight-item-content">
            <h2>
                <a href="{{ route('landing.matches') }}">
                    {{ $game->team?->name }} vs {{ $game->opponent }}
                    @if ($game->home_score !== null)
                        — {{ $game->home_score }} x {{ $game->away_score }}
                    @endif
                </a>
            </h2>
        </div>
    </div>
</div>