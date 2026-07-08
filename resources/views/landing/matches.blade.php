@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => landing_section('page_matches', 'header_title')])

@if ($upcomingGames->isNotEmpty())
<div class="our-match bg-section dark-section">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">Próximos Jogos</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Calendário da temporada</h2>
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

<div class="page-matches">
    <div class="container">
        <div class="row">
            @forelse ($recentGames as $game)
                <div class="col-xl-4 col-md-6">
                    @include('landing.partials.match-highlight', [
                        'game' => $game,
                        'index' => $loop->index,
                        'delay' => ($loop->index * 0.2).'s',
                    ])
                </div>
            @empty
                @if ($upcomingGames->isEmpty())
                    <div class="col-12 text-center py-5">
                        <p>Nenhum jogo registrado ainda.</p>
                    </div>
                @endif
            @endforelse
        </div>
    </div>
</div>
@endsection