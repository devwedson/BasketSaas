@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => 'Sobre Nós'])

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
                                @foreach (range(1, 4) as $i)
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ neodunk_asset('images/author-'.$i.'.jpg') }}" alt="">
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
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $club?->name ?? config('landing.brand.name') }}</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            {{ $club?->description ?? config('landing.brand.tagline') }}
                        </p>
                    </div>

                    <div class="about-body-item-list wow fadeInUp" data-wow-delay="0.4s">
                        <div class="about-body-item">
                            <div class="icon-box"><img src="{{ neodunk_asset('images/icon-about-us-item-1.svg') }}" alt=""></div>
                            <div class="about-body-item-content">
                                <h3>{{ $stats['players'] }} Atletas</h3>
                                <p>Elenco ativo em todas as categorias.</p>
                            </div>
                        </div>
                        <div class="about-body-item">
                            <div class="icon-box"><img src="{{ neodunk_asset('images/icon-about-us-item-2.svg') }}" alt=""></div>
                            <div class="about-body-item-content">
                                <h3>{{ $stats['teams'] }} Times</h3>
                                <p>Programas de formação e competição.</p>
                            </div>
                        </div>
                    </div>

                    @if ($club)
                        <div class="about-us-btn wow fadeInUp" data-wow-delay="0.6s">
                            <p>
                                <strong>Local:</strong> {{ $club->city }}/{{ $club->state }} — {{ $club->country }}<br>
                                @if ($club->email)<strong>E-mail:</strong> {{ $club->email }}<br>@endif
                                @if ($club->phone)<strong>Telefone:</strong> {{ $club->phone }}@endif
                            </p>
                            <a href="{{ route('landing.contact') }}" class="btn-default">Entre em Contato</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if ($staff->isNotEmpty())
<div class="our-team">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">Comissão Técnica</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Profissionais que lideram nossos times</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($staff as $member)
                <div class="col-xl-3 col-md-6">
                    @include('landing.partials.team-member', [
                        'name' => $member->name,
                        'photo' => staff_photo_url($member, 'images/team-'.(($loop->index % 8) + 1).'.jpg'),
                        'subtitle' => $member->role->label().($member->team ? ' · '.$member->team->name : ''),
                        'delay' => ($loop->index * 0.2).'s',
                        'link' => route('landing.team'),
                    ])
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection