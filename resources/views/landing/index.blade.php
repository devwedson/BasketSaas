@extends('layouts.neodunk.app')

@section('content')
<div class="hero bg-section dark-section parallaxie">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-xl-6">
                <div class="hero-content">
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">Bem-vindo ao {{ $club?->name ?? config('landing.brand.name') }}</span>
                        <h1 class="text-anime-style-3" data-cursor="-opaque">Eleve sua jornada no basquete com treino profissional</h1>
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
                            <h2><span class="counter">{{ $stats['players'] }}</span>+</h2>
                            <p>Atletas Ativos</p>
                        </div>
                    </div>

                    <div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
                        <p>{{ $club?->description ?? config('landing.brand.tagline') }}</p>
                    </div>

                    <div class="hero-button-box wow fadeInUp" data-wow-delay="0.4s">
                        <div class="hero-button">
                            <a href="{{ route('landing.contact') }}" class="btn-default">Faça Parte do Clube</a>
                        </div>
                        <div class="video-play-button">
                            <a href="{{ route('landing.about') }}" data-cursor-text="Ver">
                                <i class="fa-solid fa-play"></i>
                            </a>
                            <p>Conheça o Clube</p>
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
                                <img src="{{ neodunk_asset('images/about-us-image-2.jpg') }}" alt="">
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
                                <p>Confiado por {{ $stats['players'] }}+ atletas do clube</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="about-us-content-box">
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">Sobre o Clube</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Formando estrelas do basquete com dedicação</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            {{ $club?->description ?? 'Nossa abordagem prioriza fundamentos, trabalho em equipe e tomada de decisão inteligente em quadra, criando um ambiente onde cada atleta evolui no seu ritmo.' }}
                        </p>
                    </div>

                    <div class="about-body-item-list wow fadeInUp" data-wow-delay="0.4s">
                        <div class="about-body-item">
                            <div class="icon-box">
                                <img src="{{ neodunk_asset('images/icon-about-us-item-1.svg') }}" alt="">
                            </div>
                            <div class="about-body-item-content">
                                <h3>Base Sólida</h3>
                                <p>{{ $stats['teams'] }} times ativos com formação técnica contínua.</p>
                            </div>
                        </div>
                        <div class="about-body-item">
                            <div class="icon-box">
                                <img src="{{ neodunk_asset('images/icon-about-us-item-2.svg') }}" alt="">
                            </div>
                            <div class="about-body-item-content">
                                <h3>Competição Real</h3>
                                <p>{{ $stats['games'] }} jogos registrados na temporada.</p>
                            </div>
                        </div>
                    </div>

                    <div class="about-us-btn wow fadeInUp" data-wow-delay="0.6s">
                        <a href="{{ route('landing.about') }}" class="btn-default">Saiba Mais</a>
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
                    <span class="section-sub-title wow fadeInUp">Nossos Programas</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Categorias e times do clube</h2>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
                    <p>Programas estruturados por faixa etária, do iniciante ao competitivo, com treinos, jogos e acompanhamento da comissão técnica.</p>
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
                    <span class="section-sub-title wow fadeInUp">Confronto da Temporada</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Os jogos mais aguardados do clube</h2>
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
                    <span class="section-sub-title wow fadeInUp">Nossa Equipe</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Conheça os atletas que representam o clube em quadra</h2>
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
                    <p>Do primeiro treino à excelência — <a href="{{ route('landing.team') }}">Veja todas as equipes</a></p>
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
                        <span class="section-sub-title wow fadeInUp">Fale Conosco</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Pronto para treinar, competir ou entrar no clube?</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            Seja atleta iniciante, competitivo ou torcedor — temos programas e oportunidades para todos. Entre em contato e dê o próximo passo na sua jornada no basquete.
                        </p>
                    </div>

                    <div class="cta-box-btn wow fadeInUp" data-wow-delay="0.4s">
                        <a href="{{ route('landing.contact') }}" class="btn-default">Entre em Contato</a>
                        <a href="{{ route('landing.programs') }}" class="btn-default btn-highlighted">Conheça os Programas</a>
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
])

@include('landing.partials.home-faqs', [
    'featuredPlayers' => $featuredPlayers,
])

@include('landing.partials.home-blog', ['club' => $club])
@endsection