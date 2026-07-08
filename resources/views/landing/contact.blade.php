@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => 'Contato'])

<div class="page-contact-us">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="contact-us-content">
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">Fale Conosco!</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Entre em contato e comece sua jornada no basquete</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            Quer participar dos nossos programas, competir nos próximos jogos ou saber mais sobre o {{ $club?->name ?? 'clube' }}? Estamos prontos para ajudar.
                        </p>
                    </div>

                    <div class="contact-us-image">
                        <figure class="image-anime reveal">
                            <img src="{{ club_contact_image_url($club) }}" alt="Contato">
                        </figure>
                    </div>

                    <div class="about-body-item-list wow fadeInUp" data-wow-delay="0.3s">
                        @if ($club?->phone ?? config('landing.contact.phone'))
                            <div class="about-body-item">
                                <div class="icon-box">
                                    <img src="{{ neodunk_asset('images/icon-phone-accent-secondary.svg') }}" alt="">
                                </div>
                                <div class="about-body-item-content">
                                    <h3>Telefone</h3>
                                    <p>
                                        <a href="tel:{{ preg_replace('/\D/', '', $club?->phone ?? config('landing.contact.phone')) }}">
                                            {{ $club?->phone ?? config('landing.contact.phone_display', config('landing.contact.phone')) }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($club?->email ?? config('landing.contact.email'))
                            <div class="about-body-item">
                                <div class="icon-box">
                                    <img src="{{ neodunk_asset('images/icon-mail-accent-secondary.svg') }}" alt="">
                                </div>
                                <div class="about-body-item-content">
                                    <h3>E-mail</h3>
                                    <p>
                                        <a href="mailto:{{ $club?->email ?? config('landing.contact.email') }}">
                                            {{ $club?->email ?? config('landing.contact.email') }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($club?->address ?? $club?->city ?? config('landing.contact.address'))
                            <div class="about-body-item">
                                <div class="icon-box">
                                    <img src="{{ neodunk_asset('images/icon-location-white.svg') }}" alt="">
                                </div>
                                <div class="about-body-item-content">
                                    <h3>Endereço</h3>
                                    <p>
                                        @if ($club?->address ?? config('landing.contact.address'))
                                            {{ $club?->address ?? config('landing.contact.address') }}
                                        @else
                                            {{ $club->city }}/{{ $club->state }} — {{ $club->country }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="contact-us-form">
                    <div class="contact-form-content">
                        <h2 class="wow fadeInUp">Preencha o formulário</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Nossa equipe analisa sua mensagem e retorna em até 24 horas úteis.</p>
                    </div>

                    <div class="contact-form">
                        <form action="mailto:{{ $club?->email ?? config('landing.contact.email', 'contato@basketsaas.com') }}" method="post" enctype="text/plain" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.4s">
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <label>Nome:</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Seu nome *" required>
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <label>Telefone:</label>
                                    <input type="text" name="telefone" class="form-control" placeholder="Seu telefone">
                                </div>
                                <div class="form-group col-md-12 mb-4">
                                    <label>E-mail:</label>
                                    <input type="email" name="email" class="form-control" placeholder="Seu e-mail *" required>
                                </div>
                                <div class="form-group col-md-12 mb-5">
                                    <label>Mensagem:</label>
                                    <textarea name="mensagem" class="form-control" rows="5" placeholder="Sua mensagem..." required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn-default">Enviar Mensagem</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection