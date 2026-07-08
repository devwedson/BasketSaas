<div class="team-item wow fadeInUp" @if(!empty($delay)) data-wow-delay="{{ $delay }}" @endif>
    <div class="team-item-image">
        <a href="{{ $link ?? route('landing.team') }}" data-cursor-text="Ver">
            <figure>
                <img src="{{ $photo }}" alt="{{ $name }}">
            </figure>
        </a>
    </div>
    <div class="team-item-body">
        <div class="team-item-content">
            <h2><a href="{{ $link ?? route('landing.team') }}">{{ $name }}</a></h2>
            <p>{{ $subtitle }}</p>
        </div>
        <div class="team-social-list">
            <ul>
                @if (config('landing.social.facebook'))
                    <li><a href="{{ config('landing.social.facebook') }}" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a></li>
                @endif
                @if (config('landing.social.instagram'))
                    <li><a href="{{ config('landing.social.instagram') }}" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a></li>
                @endif
                @if (config('landing.social.linkedin'))
                    <li><a href="{{ config('landing.social.linkedin') }}" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a></li>
                @endif
                @if (config('landing.social.youtube'))
                    <li><a href="{{ config('landing.social.youtube') }}" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
</div>