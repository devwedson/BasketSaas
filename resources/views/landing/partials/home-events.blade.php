@if ($eventPhotos->isNotEmpty())
<div class="page-blog home-events-gallery">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('home_events', 'subtitle', '', $stats, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_events', 'title', '', $stats, $club) }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">{{ landing_section('home_events', 'description', '', $stats, $club) }}</p>
                </div>
            </div>
        </div>

        <div class="row post-item-list">
            @foreach ($eventPhotos as $photo)
                @include('landing.partials.event-photo-card', [
                    'photo' => $photo,
                    'delay' => ($loop->index * 0.15).'s',
                ])
            @endforeach
        </div>

        @if ($eventPhotos->count() >= 3)
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-footer-text wow fadeInUp" data-wow-delay="0.3s">
                        <p>{{ landing_section('home_events', 'footer_text', '', $stats, $club) }}
                            <a href="{{ landing_route(landing_section('home_events', 'footer_route', 'landing.events', $stats, $club)) }}">
                                {{ landing_section('home_events', 'footer_link', '', $stats, $club) }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endif