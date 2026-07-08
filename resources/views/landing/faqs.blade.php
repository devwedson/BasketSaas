@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => landing_section('page_faqs', 'header_title')])

<div class="page-faqs">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="page-single-sidebar">
                    <div class="page-category-list wow fadeInUp">
                        <ul>
                            @foreach ($faqCategories as $category)
                                <li><a href="#{{ $category['id'] }}">{{ $category['category'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="sidebar-cta-box wow fadeInUp" data-wow-delay="0.25s">
                        <div class="icon-box">
                            <img src="{{ neodunk_asset('images/icon-headphone-white.svg') }}" alt="">
                        </div>
                        <div class="sidebar-cta-box-content">
                            <h2>{{ landing_section('page_faqs', 'sidebar_cta_title') }}</h2>
                            <p>{{ landing_section('page_faqs', 'sidebar_cta_text') }}</p>
                            @if ($club?->phone ?? config('landing.contact.phone'))
                                <h3>Telefone: <a href="tel:{{ preg_replace('/\D/', '', $club?->phone ?? config('landing.contact.phone')) }}">{{ $club?->phone ?? config('landing.contact.phone_display') }}</a></h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="page-faqs-catagery">
                    @php $accordionIndex = 0; $firstAccordion = true; @endphp
                    @foreach ($faqCategories as $category)
                        <div class="page-single-faqs" id="{{ $category['id'] }}">
                            <div class="section-title">
                                <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category['category'] }}</h2>
                            </div>

                            <div class="faq-accordion our-faq-accordion" id="accordion-{{ $category['id'] }}">
                                @foreach ($category['items'] as $item)
                                    @php
                                        $accordionIndex++;
                                        $headingId = 'heading'.$accordionIndex;
                                        $collapseId = 'collapse'.$accordionIndex;
                                        $isFirst = $firstAccordion;
                                        if ($isFirst) { $firstAccordion = false; }
                                    @endphp
                                    <div class="accordion-item wow fadeInUp" @if(!$loop->first) data-wow-delay="{{ $loop->index * 0.1 }}s" @endif>
                                        <h2 class="accordion-header" id="{{ $headingId }}">
                                            <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $isFirst ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                                {{ $item['question'] }}
                                            </button>
                                        </h2>
                                        <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}" role="region" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordion-{{ $category['id'] }}">
                                            <div class="accordion-body">
                                                <p>{{ $item['answer'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection