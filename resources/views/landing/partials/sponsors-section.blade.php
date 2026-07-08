@if (($sponsors ?? collect())->isNotEmpty())
@php
    $stats = $stats ?? null;
    $club = $club ?? null;
@endphp
<div class="landing-sponsors-section">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('home_sponsors', 'subtitle', '', $stats, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_sponsors', 'title', '', $stats, $club) }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">{{ landing_section('home_sponsors', 'description', '', $stats, $club) }}</p>
                </div>
            </div>
        </div>

        <div class="row landing-sponsors-grid">
            @foreach ($sponsors as $sponsor)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="landing-sponsor-card wow fadeInUp" data-wow-delay="{{ ($loop->index % 4) * 0.1 }}s">
                        <div class="landing-sponsor-logo">
                            @if ($sponsor->website)
                                <a href="{{ $sponsor->website }}" target="_blank" rel="noopener noreferrer" title="{{ $sponsor->name }}">
                                    <img src="{{ sponsor_logo_url($sponsor, $loop->index) }}" alt="{{ $sponsor->name }}">
                                </a>
                            @else
                                <img src="{{ sponsor_logo_url($sponsor, $loop->index) }}" alt="{{ $sponsor->name }}">
                            @endif
                        </div>
                        <div class="landing-sponsor-body">
                            <h3>{{ $sponsor->name }}</h3>
                            <span class="landing-sponsor-tier landing-sponsor-tier--{{ $sponsor->tier->value }}">{{ $sponsor->tier->label() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif