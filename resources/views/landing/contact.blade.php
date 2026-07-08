@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => landing_section('page_contact', 'header_title')])

<div class="page-contact-us">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="contact-us-content">
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">{{ landing_section('page_contact', 'subtitle', '', $stats ?? null, $club) }}</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('page_contact', 'title', '', $stats ?? null, $club) }}</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            {{ landing_section('page_contact', 'description', '', $stats ?? null, $club) }}
                        </p>
                    </div>

                    <div class="contact-us-image">
                        <figure class="image-anime reveal">
                            <img src="{{ is_custom_media_path(config('landing.images.contact')) ? landing_image('contact') : club_contact_image_url($club) }}" alt="Contato {{ $club?->name ?? config('landing.brand.name') }}">
                        </figure>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="contact-us-form">
                    <div class="contact-form-content">
                        <h2 class="wow fadeInUp">{{ landing_section('page_contact', 'form_title') }}</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">{{ landing_section('page_contact', 'form_subtitle') }}</p>
                    </div>

                    <div class="contact-form">
                        <form id="contactForm" action="mailto:{{ $club?->email ?? config('landing.contact.email', 'contato@basketsaas.com') }}" method="post" enctype="text/plain" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.4s">
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <label for="fname">Nome:</label>
                                    <input type="text" name="fname" class="form-control" id="fname" placeholder="Seu nome *" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <label for="lname">Sobrenome:</label>
                                    <input type="text" name="lname" class="form-control" id="lname" placeholder="Seu sobrenome *" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <label for="email">E-mail:</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Seu e-mail *" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <label for="phone">Telefone:</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Seu telefone">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-12 mb-5">
                                    <label for="message">Mensagem:</label>
                                    <textarea name="message" class="form-control" id="message" rows="5" placeholder="Sua mensagem..." required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn-default">Enviar Mensagem</button>
                                    <div id="msgSubmit" class="h3 hidden"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $mapQuery = urlencode(trim(($club?->address ?? config('landing.contact.address', '')).' '.($club?->city ?? '').' '.($club?->state ?? '').' '.($club?->country ?? 'Brasil')));
@endphp

<div class="google-map">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">{{ landing_section('page_contact', 'map_subtitle') }}</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('page_contact', 'map_title') }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">{{ landing_section('page_contact', 'map_description') }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                @include('landing.partials.contact-info-items', ['club' => $club])
            </div>
        </div>

        @if ($mapQuery)
            <div class="row">
                <div class="col-lg-12">
                    <div class="google-map-iframe wow fadeInUp" data-wow-delay="0.4s">
                        <iframe
                            src="https://maps.google.com/maps?q={{ $mapQuery }}&amp;hl=pt&amp;z=15&amp;output=embed"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Mapa — {{ $club?->name ?? config('landing.brand.name') }}"
                        ></iframe>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .google-map .about-body-item-list {
        margin-bottom: 40px;
    }

    .contact-info-item {
        width: calc(33.333% - 20px);
        min-width: 220px;
        flex: 1 1 220px;
    }

    .about-body-item-list .icon-box-light {
        background: var(--bg-color, #f5f0eb);
    }

    .about-body-item-list .icon-box-light img {
        max-width: 22px;
    }

    @media (max-width: 991px) {
        .contact-info-item {
            width: calc(50% - 15px);
        }
    }

    @media (max-width: 575px) {
        .contact-info-item {
            width: 100%;
        }
    }
</style>
@endpush