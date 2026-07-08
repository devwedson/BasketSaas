@extends('layouts.neodunk.app')

@section('content')
<div class="page-header bg-section parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-box">
                    <h1 class="text-anime-style-3" data-cursor="-opaque">{{ $team->name }}</h1>
                    <nav class="wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('landing') }}">Início</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('landing.team') }}">Equipes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $team->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-team-single">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-3 col-md-4 text-center mb-4 mb-md-0">
                <div class="team-logo wow fadeInUp">
                    <figure>
                        <img src="{{ team_logo_url($team) }}" alt="{{ $team->name }}">
                    </figure>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="section-title wow fadeInUp" data-wow-delay="0.2s">
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $team->name }}</h2>
                    @if ($team->category)
                        <p><strong>Categoria:</strong> {{ $team->category }}</p>
                    @endif
                    @if ($team->description)
                        <p>{{ $team->description }}</p>
                    @endif
                    <p>{{ $team->players_count }} {{ $team->players_count === 1 ? 'atleta' : 'atletas' }} no elenco</p>
                </div>
            </div>
        </div>

        @if ($staff->isNotEmpty())
            <div class="our-team mb-5">
                <div class="row section-row">
                    <div class="col-lg-12">
                        <div class="section-title section-title-center">
                            <span class="section-sub-title wow fadeInUp">Comissão Técnica</span>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Profissionais da equipe</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($staff as $member)
                        <div class="col-xl-3 col-md-6">
                            @include('landing.partials.team-member', [
                                'name' => $member->name,
                                'photo' => staff_photo_url($member, 'images/team-'.(($loop->index % 8) + 1).'.jpg'),
                                'subtitle' => $member->role->label(),
                                'delay' => ($loop->index * 0.2).'s',
                                'link' => route('landing.team.show', $team),
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="page-team">
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Elenco</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Atletas da equipe</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse ($players as $player)
                    <div class="col-xl-3 col-md-6">
                        @include('landing.partials.player-card', [
                            'player' => $player,
                            'index' => $loop->index,
                            'delay' => ($loop->index * 0.2).'s',
                            'team' => $team,
                        ])
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p>Nenhum atleta cadastrado nesta equipe ainda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection