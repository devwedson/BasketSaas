@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => landing_section('page_events', 'header_title', 'Eventos', $stats ?? null, $club ?? null)])

<div class="page-blog">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('page_events', 'subtitle', '', $stats, $club) }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('page_events', 'title', '', $stats, $club) }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">{{ landing_section('page_events', 'description', '', $stats, $club) }}</p>
                </div>
            </div>
        </div>

        <div class="row post-item-list">
            @forelse ($eventPhotos as $photo)
                @include('landing.partials.event-photo-card', [
                    'photo' => $photo,
                    'delay' => ($loop->index * 0.15).'s',
                ])
            @empty
                <div class="col-12 text-center py-5">
                    <p>Nenhuma foto de evento publicada ainda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection