@extends('layouts.neodunk.app')

@section('content')
<div class="hero bg-section dark-section parallaxie">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-xl-6">
                <div class="hero-content">
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">{{ landing_section('hero', 'subtitle_prefix', '', $stats, $club) }} {{ $club?->name ?? config('landing.brand.name') }}</span>
                        <h1 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('hero', 'title', '', $stats, $club) }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="hero-content-btn">
                    <div class="hero-client-box wow fadeInUp">
                        <div class="satisfy-client-images">
                            @foreach ($featuredPlayers->take(4) as $player)
                                <div class="satisfy-client-image">
                                    <figure class="image-anime">
                                        <img src="{{ player_photo_url($player, 'images/author-'.($loop->iteration).'.jpg') }}" alt="{{ $player->name }}">
                                    </figure>
                                </div>
                            @endforeach
                        </div>
                        <div class="hero-client-box-content">
                            <h2><span class="counter">{{ $stats['players'] }}</span>{{ landing_section('hero', 'counter_suffix', '+', $stats, $club) }}</h2>
                            <p>{{ landing_section('hero', 'counter_label', '', $stats, $club) }}</p>
                        </div>
                    </div>

                    <div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
                        <p>{{ $club?->description ?? config('landing.brand.tagline') }}</p>
                    </div>

                    <div class="hero-button-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="hero-button">
                            <a href="{{ landing_route(landing_section('hero', 'btn_primary_route', 'landing.contact', $stats, $club)) }}" class="btn-default">{{ landing_section('hero', 'btn_primary', '', $stats, $club) }}</a>
                        </div>
                        <div class="video-play-button">
                            <a href="{{ landing_route(landing_section('hero', 'btn_secondary_route', 'landing.about', $stats, $club)) }}" data-cursor-text="Ver">
                                <i class="fa-solid fa-play"></i>
                            </a>
                            <p>{{ landing_section('hero', 'btn_secondary', '', $stats, $club) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-us">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5">
                <div class="about-us-image-box wow fadeInUp">
                    <div class="about-us-image-box-1">
                        <div class="about-us-image">
                            <figure>
                                <img src="{{ club_cover_image_url($club) }}" alt="{{ $club?->name }}">
                            </figure>
                        </div>
                    </div>
                    <div class="about-us-image-box-2">
                        <div class="about-us-image">
                            <figure class="image-anime">
                                <img src="{{ landing_image('about_secondary') }}" alt="">
                            </figure>
                        </div>
                        <div class="about-trusted-player-box">
                            <div class="satisfy-client-images">
                                @foreach ($featuredPlayers->take(4) as $player)
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ player_photo_url($player, 'images/author-'.($loop->iteration).'.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                            <div class="about-trusted-player-box-content">
                                <p>{{ landing_section('home_about', 'trusted_text', '', $stats, $club) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="about-us-content-box">
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">{{ landing_section('home_about', 'subtitle', '', $stats, $club) }}</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_about', 'title', '', $stats, $club) }}</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            {{ $club?->description ?? landing_section('home_about', 'description', '', $stats, $club) }}
                        </p>
                    </div>

                    <div class="about-body-item-list wow fadeInUp" data-wow-delay="0.4s">
                        <div class="about-body-item">
                            <div class="icon-box">
                                <img src="{{ neodunk_asset('images/icon-about-us-item-1.svg') }}" alt="">
                            </div>
                            <div class="about-body-item-content">
                                <h3>{{ landing_section('home_about', 'feature_1_title', '', $stats, $club) }}</h3>
                                <p>{{ landing_section('home_about', 'feature_1_text', '', $stats, $club) }}</p>
                            </div>
                        </div>
                        <div class="about-body-item">
                            <div class="icon-box">
                                <img src="{{ neodunk_asset('images/icon-about-us-item-2.svg') }}" alt="">
                            </div>
                            <div class="about-body-item-content">
                                <h3>{{ landing_section('home_about', 'feature_2_title', '', $stats, $club) }}</h3>
                                <p>{{ landing_section('home_about', 'feature_2_text', '', $stats, $club) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="about-us-btn wow fadeInUp" data-wow-delay="0.6s">
                        <a href="{{ landing_route(landing_section('home_about', 'btn_route', 'landing.about', $stats, $club)) }}" class="btn-default">{{ landing_section('home_about', 'btn', '', $stats, $club) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="our-program">
    <div class="container">
        <div class="row section-row align-items-center">
            <div class="col-xl-6">
                <div class="section-title">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('home_programs', 'subtitle', '', $stats, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_programs', 'title', '', $stats, $club) }}</h2>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
                    <p>{{ landing_section('home_programs', 'description', '', $stats, $club) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($teams as $team)
                <div class="col-xl-3 col-md-6">
                    <div class="program-item wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 }}s">
                        <div class="program-item-image">
                            <a href="{{ route('landing.programs') }}" data-cursor-text="Ver">
                                <figure>
                                    <img src="{{ team_program_image_url($team, $loop->index) }}" alt="{{ $team->name }}">
                                </figure>
                            </a>
                        </div>
                        <div class="program-item-body">
                            <div class="program-item-content">
                                <h2><a href="{{ route('landing.programs') }}">{{ $team->name }}</a></h2>
                                <p>{{ $team->description ?? ($team->category ? 'Categoria '.$team->category : 'Programa de formação e competição') }}</p>
                            </div>
                            <div class="program-readmore-btn">
                                <a href="{{ route('landing.programs') }}" class="readmore-btn">Ver Mais</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Nenhum time cadastrado ainda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@if ($upcomingGames->isNotEmpty())
<div class="our-match bg-section dark-section">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('home_matches', 'subtitle', '', $stats, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_matches', 'title', '', $stats, $club) }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="our-match-items-list wow fadeInUp" data-wow-delay="0.2s">
                    @foreach ($upcomingGames as $game)
                        @include('landing.partials.match-item', ['game' => $game, 'index' => $loop->index])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="our-team">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('home_team', 'subtitle', '', $stats, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_team', 'title', '', $stats, $club) }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($featuredPlayers as $player)
                <div class="col-xl-3 col-md-6">
                    @include('landing.partials.player-card', [
                        'player' => $player,
                        'index' => $loop->index,
                        'delay' => ($loop->index * 0.2).'s',
                    ])
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="section-footer-text wow fadeInUp" data-wow-delay="0.4s">
                    <p>{{ landing_section('home_team', 'footer_text', '', $stats, $club) }} <a href="{{ landing_route(landing_section('home_team', 'footer_route', 'landing.team', $stats, $club)) }}">{{ landing_section('home_team', 'footer_link', '', $stats, $club) }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cta-box bg-section dark-section parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-box-content">
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">{{ landing_section('home_cta', 'subtitle', '', $stats, $club) }}</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_cta', 'title', '', $stats, $club) }}</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            {{ landing_section('home_cta', 'description', '', $stats, $club) }}
                        </p>
                    </div>

                    <div class="cta-box-btn wow fadeInUp" data-wow-delay="0.4s">
                        <a href="{{ landing_route(landing_section('home_cta', 'btn_primary_route', 'landing.contact', $stats, $club)) }}" class="btn-default">{{ landing_section('home_cta', 'btn_primary', '', $stats, $club) }}</a>
                        <a href="{{ landing_route(landing_section('home_cta', 'btn_secondary_route', 'landing.programs', $stats, $club)) }}" class="btn-default btn-highlighted">{{ landing_section('home_cta', 'btn_secondary', '', $stats, $club) }}</a>
                    </div>
                </div>

                @if ($sponsors->isNotEmpty())
                    @include('landing.partials.sponsors-slider', ['sponsors' => $sponsors])
                @endif
            </div>
        </div>
    </div>
</div>

@include('landing.partials.home-testimonials', [
    'club' => $club,
    'featuredPlayers' => $featuredPlayers,
    'stats' => $stats,
])

@include('landing.partials.home-faqs', [
    'featuredPlayers' => $featuredPlayers,
    'stats' => $stats,
    'club' => $club,
])

@include('landing.partials.home-blog', ['club' => $club, 'stats' => $stats])
@endsection