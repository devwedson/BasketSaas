<div class="team-item wow fadeInUp" @if(!empty($delay)) data-wow-delay="{{ $delay }}" @endif>
    <div class="team-item-image">
        <a href="{{ route('landing.team.show', $team) }}" data-cursor-text="Ver">
            <figure class="d-flex align-items-center justify-content-center p-4" style="min-height: 220px; background: rgba(255,255,255,0.04);">
                <img src="{{ team_logo_url($team, 'images/team-logo-'.((($index ?? 0) % 6) + 1).'.png') }}" alt="{{ $team->name }}" style="max-height: 140px; width: auto; max-width: 100%; object-fit: contain;">
            </figure>
        </a>
    </div>
    <div class="team-item-body">
        <div class="team-item-content">
            <h2><a href="{{ route('landing.team.show', $team) }}">{{ $team->name }}</a></h2>
            <p>
                {{ $team->category ? $team->category.' · ' : '' }}
                {{ $team->players_count }} {{ $team->players_count === 1 ? 'atleta' : 'atletas' }}
            </p>
        </div>
        <div class="team-social-list">
            <ul>
                <li>
                    <a href="{{ route('landing.team.show', $team) }}" title="Ver elenco">
                        <i class="fa-solid fa-users"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>