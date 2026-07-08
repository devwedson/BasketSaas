@if (($sponsors ?? collect())->isNotEmpty())
<div class="footer-sponsors">
    <div class="container">
        <p class="footer-sponsors-title">{{ landing_section('home_sponsors', 'footer_title', 'Nossos patrocinadores', null, $club ?? null) }}</p>
        <div class="footer-sponsors-logos">
            @foreach ($sponsors as $sponsor)
                <div class="footer-sponsor-item">
                    @if ($sponsor->website)
                        <a href="{{ $sponsor->website }}" target="_blank" rel="noopener noreferrer" title="{{ $sponsor->name }}">
                            <img src="{{ sponsor_logo_url($sponsor, $loop->index) }}" alt="{{ $sponsor->name }}">
                        </a>
                    @else
                        <img src="{{ sponsor_logo_url($sponsor, $loop->index) }}" alt="{{ $sponsor->name }}">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif