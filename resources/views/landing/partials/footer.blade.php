@php
    $contactPhone = $club?->phone ?? config('landing.contact.phone');
    $contactEmail = $club?->email ?? config('landing.contact.email');
    $contactAddress = $club?->address ?? config('landing.contact.address');
    $contactCityLine = $club?->city
        ? trim($club->city.($club->state ? '/'.$club->state : '').($club->country ? ' — '.$club->country : ''))
        : null;
    $socials = array_filter(config('landing.social', []));
@endphp

<footer class="main-footer bg-section dark-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-header">
                    <div class="footer-header-title">
                        <h2>Receba novidades exclusivas sobre jogos, eventos e o clube!</h2>
                    </div>

                    <div class="footer-newsletter-form">
                        <form id="newslettersForm" action="#" method="POST">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Seu e-mail *" required>
                                <button type="submit" class="btn-default btn-highlighted">Inscrever-se</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="footer-body">
                    @if ($contactAddress || $contactCityLine)
                        <div class="footer-body-contact-item">
                            <h3>Nossa Localização</h3>
                            <ul>
                                <li>
                                    <img src="{{ neodunk_asset('images/icon-location-white.svg') }}" alt="">
                                    {{ $contactAddress ?: $contactCityLine }}
                                </li>
                            </ul>
                        </div>
                    @endif

                    <div class="about-footer">
                        <div class="footer-logo">
                            <img src="{{ landing_brand_logo_url($club ?? null) }}" alt="{{ landing_brand_name($club ?? null) }}">
                        </div>
                        <div class="about-footer-content">
                            <p>{{ $club?->description ?? config('landing.brand.tagline') }}</p>
                        </div>
                    </div>

                    @if ($contactPhone || $contactEmail)
                        <div class="footer-body-contact-item">
                            <h3>Informações de Contato</h3>
                            <ul>
                                @if ($contactPhone)
                                    <li>
                                        <img src="{{ neodunk_asset('images/icon-phone-white.svg') }}" alt="">
                                        Telefone:
                                        <a href="tel:{{ preg_replace('/\D/', '', $contactPhone) }}">
                                            {{ config('landing.contact.phone_display', $contactPhone) }}
                                        </a>
                                    </li>
                                @endif
                                @if ($contactEmail)
                                    <li>
                                        <img src="{{ neodunk_asset('images/icon-mail-white.svg') }}" alt="">
                                        E-mail:
                                        <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="footer-menu-box">
                    <div class="footer-menu">
                        <ul>
                            @foreach (config('landing.menu', []) as $item)
                                @if (Route::has($item['route']))
                                    <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    @if (count($socials))
                        <div class="footer-social-links">
                            <h3>Siga-nos nas redes:</h3>
                            <ul>
                                @if (config('landing.social.facebook'))
                                    <li><a href="{{ config('landing.social.facebook') }}" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a></li>
                                @endif
                                @if (config('landing.social.instagram'))
                                    <li><a href="{{ config('landing.social.instagram') }}" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a></li>
                                @endif
                                @if (config('landing.social.linkedin'))
                                    <li><a href="{{ config('landing.social.linkedin') }}" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                @endif
                                @if (config('landing.social.youtube'))
                                    <li><a href="{{ config('landing.social.youtube') }}" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>