@if ($sponsors->isNotEmpty())
@php
    $sponsorSlides = $sponsors->count() < 7
        ? $sponsors->concat($sponsors)
        : $sponsors;
@endphp
<div class="cta-company-slider-box wow fadeInUp" data-wow-delay="0.2s">
    <div class="cta-company-slider-content">
        <hr>
        <h3>{{ landing_section('home_cta', 'sponsors_title') }}</h3>
        <hr>
    </div>

    <div class="cta-company-slider">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($sponsorSlides as $sponsor)
                    <div class="swiper-slide">
                        <div class="company-logo">
                            @if ($sponsor->website)
                                <a href="{{ $sponsor->website }}" target="_blank" rel="noopener noreferrer" title="{{ $sponsor->name }}">
                                    <img src="{{ sponsor_logo_url($sponsor, $loop->index) }}" alt="{{ $sponsor->name }}">
                                </a>
                            @else
                                <img src="{{ sponsor_logo_url($sponsor, $loop->index) }}" alt="{{ $sponsor->name }}">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif