@php
    $quotes = config('landing.testimonials', []);
    $slides = $featuredPlayers->take(3)->values();
    $stats = $stats ?? null;
    $club = $club ?? null;
@endphp

@if ($slides->isNotEmpty())
<div class="our-testimonials">
    <div class="container">
        <div class="row section-row align-items-center">
            <div class="col-xl-6">
                <div class="section-title">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('home_testimonials', 'subtitle', '', $stats, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_testimonials', 'title', '', $stats, $club) }}</h2>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="section-content-btn">
                    <div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
                        <p>{{ landing_section('home_testimonials', 'description', '', $stats, $club) }}</p>
                    </div>
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.4s">
                        <a href="{{ landing_route(landing_section('home_testimonials', 'btn_route', 'landing.about', $stats, $club)) }}" class="btn-default">{{ landing_section('home_testimonials', 'btn', '', $stats, $club) }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <div class="testimonial-image">
                    <figure class="image-anime reveal">
                        <img src="{{ landing_image('testimonial') }}" alt="Depoimentos {{ landing_brand_name($club ?? null) }}">
                    </figure>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="testimonial-slider wow fadeInUp">
                    <div class="swiper">
                        <div class="swiper-wrapper" data-cursor-text="Arrastar">
                            @foreach ($slides as $player)
                                @php $quote = $quotes[$loop->index]['quote'] ?? $quotes[0]['quote'] ?? ''; @endphp
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-item-rating">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                        </div>
                                        <div class="testimonial-item-body">
                                            <div class="testimonial-item-content">
                                                <p>“{{ $quote }}”</p>
                                            </div>
                                            <div class="testimonial-item-author">
                                                <div class="testimonial-author-content">
                                                    <h2>{{ $player->name }}</h2>
                                                    <p>{{ $player->position ?? 'Atleta' }}{{ $player->team?->name ? ' · '.$player->team->name : '' }}</p>
                                                </div>
                                                <div class="testimonial-author-image">
                                                    <figure>
                                                        <img src="{{ player_photo_url($player, 'images/author-'.($loop->iteration).'.jpg') }}" alt="{{ $player->name }}">
                                                    </figure>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="section-footer-text section-satisfy-img wow fadeInUp" data-wow-delay="0.2s">
                    <div class="satisfy-client-images">
                        @foreach ($featuredPlayers->take(1) as $player)
                            <div class="satisfy-client-image">
                                <figure class="image-anime">
                                    <img src="{{ player_photo_url($player, 'images/author-1.jpg') }}" alt="">
                                </figure>
                            </div>
                        @endforeach
                        <div class="satisfy-client-image add-more">
                            <img src="{{ neodunk_asset('images/icon-phone-white.svg') }}" alt="">
                        </div>
                    </div>
                    <p>{{ landing_section('home_testimonials', 'footer_text', '', $stats, $club) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif