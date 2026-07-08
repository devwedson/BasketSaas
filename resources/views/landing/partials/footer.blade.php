<footer class="main-footer bg-section dark-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-header">
                    <div class="footer-header-title">
                        <h2>{{ config('landing.brand.name') }}</h2>
                    </div>
                </div>

                <div class="footer-body">
                    <div class="about-footer">
                        <div class="footer-logo">
                            <img src="{{ landing_brand_logo_url($club ?? null) }}" alt="{{ landing_brand_name($club ?? null) }}">
                        </div>
                        <div class="about-footer-content">
                            <p>{{ config('landing.brand.tagline') }}</p>
                        </div>
                    </div>

                    @php
                        $contactPhone = $club?->phone ?? config('landing.contact.phone');
                        $contactEmail = $club?->email ?? config('landing.contact.email');
                        $contactAddress = $club?->address ?? config('landing.contact.address');
                    @endphp
                    @if ($contactPhone || $contactEmail || $contactAddress)
                        <div class="footer-body-contact-item">
                            <h3>Contato</h3>
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
                                @if ($contactAddress)
                                    <li>{{ $contactAddress }}</li>
                                @elseif ($club?->city)
                                    <li>{{ $club->city }}/{{ $club->state }} — {{ $club->country }}</li>
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

                    @php $socials = array_filter(config('landing.social', [])); @endphp
                    @if (count($socials))
                        <div class="footer-social-links">
                            <h3>Redes Sociais</h3>
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