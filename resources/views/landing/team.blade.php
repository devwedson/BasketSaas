@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => 'Nossa Equipe'])

@if ($staff->isNotEmpty())
<div class="our-team">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">Comissão Técnica</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Profissionais do {{ $club?->name ?? 'clube' }}</h2>
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
                        'link' => route('landing.team'),
                    ])
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="page-team">
    <div class="container">
        <div class="row">
            @forelse ($players as $player)
                <div class="col-xl-3 col-md-6">
                    @include('landing.partials.player-card', [
                        'player' => $player,
                        'index' => $loop->index,
                        'delay' => ($loop->index * 0.2).'s',
                    ])
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p>Nenhum atleta cadastrado ainda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection