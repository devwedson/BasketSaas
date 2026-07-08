@php
    $homeFaqs = collect(config('landing.faqs', []))
        ->flatMap(fn ($category) => $category['items'])
        ->take(5)
        ->values();
    $stats = $stats ?? null;
    $club = $club ?? null;
@endphp

@if ($homeFaqs->isNotEmpty())
<div class="our-faqs bg-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-5">
                <div class="faq-image-box wow fadeInUp">
                    <div class="faq-image">
                        <figure class="image-anime">
                            <img src="{{ landing_image('faq') }}" alt="Perguntas frequentes">
                        </figure>
                    </div>

                    <div class="faq-client-box">
                        <div class="faq-client-content">
                            <h3>{{ landing_section('home_faqs', 'sidebar_title', '', $stats, $club) }}</h3>
                        </div>
                        <div class="satisfy-client-images">
                            @foreach ($featuredPlayers->take(5) as $player)
                                <div class="satisfy-client-image">
                                    <figure class="image-anime">
                                        <img src="{{ player_photo_url($player, 'images/author-'.($loop->iteration).'.jpg') }}" alt="">
                                    </figure>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="faq-content">
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">{{ landing_section('home_faqs', 'subtitle', '', $stats, $club) }}</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ landing_section('home_faqs', 'title', '', $stats, $club) }}</h2>
                    </div>

                    <div class="faq-accordion" id="home-faq-accordion">
                        @foreach ($homeFaqs as $item)
                            @php
                                $headingId = 'homeFaqHeading'.$loop->iteration;
                                $collapseId = 'homeFaqCollapse'.$loop->iteration;
                                $isFirst = $loop->first;
                            @endphp
                            <div class="accordion-item wow fadeInUp" @if(!$isFirst) data-wow-delay="{{ ($loop->index * 0.2) }}s" @endif>
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button
                                        class="accordion-button {{ $isFirst ? '' : 'collapsed' }}"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="{{ $isFirst ? 'true' : 'false' }}"
                                        aria-controls="{{ $collapseId }}"
                                    >
                                        {{ $item['question'] }}
                                    </button>
                                </h2>
                                <div
                                    id="{{ $collapseId }}"
                                    class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}"
                                    role="region"
                                    aria-labelledby="{{ $headingId }}"
                                    data-bs-parent="#home-faq-accordion"
                                >
                                    <div class="accordion-body">
                                        <p>{{ $item['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-btn wow fadeInUp" data-wow-delay="0.4s" style="margin-top: 30px;">
                        <a href="{{ landing_route(landing_section('home_faqs', 'btn_route', 'landing.faqs', $stats, $club)) }}" class="btn-default">{{ landing_section('home_faqs', 'btn', '', $stats, $club) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif