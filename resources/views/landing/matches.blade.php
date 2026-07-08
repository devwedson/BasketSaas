@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => landing_section('page_matches', 'header_title')])

@if ($upcomingGames->isNotEmpty())
<div class="page-matches page-matches-upcoming-intro">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('page_matches', 'upcoming_subtitle') }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('page_matches', 'upcoming_title') }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="our-match bg-section dark-section page-matches-calendar">
    <div class="container">
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

@if ($recentGames->isNotEmpty())
<div class="page-matches page-matches-results">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('page_matches', 'recent_subtitle') }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('page_matches', 'recent_title') }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($recentGames as $game)
                <div class="col-xl-4 col-md-6">
                    @include('landing.partials.match-highlight', [
                        'game' => $game,
                        'index' => $loop->index,
                        'delay' => ($loop->index * 0.2).'s',
                    ])
                </div>
            @endforeach
        </div>
    </div>
</div>
@elseif ($upcomingGames->isEmpty())
<div class="page-matches">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center py-5">
                <p>Nenhum jogo registrado ainda.</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .page-matches-upcoming-intro {
        padding: 100px 0 0;
    }

    .page-matches-calendar.our-match {
        padding-top: 0;
    }

    .page-matches-results {
        padding: 100px 0 70px;
    }

    @media (max-width: 991px) {
        .page-matches-upcoming-intro {
            padding-top: 50px;
        }

        .page-matches-results {
            padding: 50px 0 20px;
        }
    }
</style>
@endpush