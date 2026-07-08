@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => landing_section('page_team', 'header_title')])

<div class="page-team">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('page_team', 'subtitle', '', $stats ?? null, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('page_team', 'title', '', $stats ?? null, $club) }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">{{ landing_section('page_team', 'description', '', $stats ?? null, $club) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($teams as $team)
                <div class="col-xl-3 col-md-6">
                    @include('landing.partials.team-card', [
                        'team' => $team,
                        'index' => $loop->index,
                        'delay' => ($loop->index * 0.2).'s',
                    ])
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p>Nenhuma equipe cadastrada ainda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection