<div class="col-xl-4 col-md-6">
    <div class="post-item wow fadeInUp" @if (!empty($delay)) data-wow-delay="{{ $delay }}" @endif>
        <div class="post-featured-image">
            <a href="{{ event_photo_url($photo) }}" data-cursor-text="Ver" class="event-photo-lightbox" title="{{ $photo->title }}">
                <figure class="image-anime">
                    <img src="{{ event_photo_url($photo) }}" alt="{{ $photo->title }}">
                </figure>
            </a>
        </div>
        <div class="post-item-body">
            <div class="post-item-meta">
                <ul>
                    @if ($photo->event_date)
                        <li>{{ $photo->event_date->format('d/m/Y') }}</li>
                    @endif
                    <li>Evento</li>
                </ul>
            </div>
            <div class="post-item-content">
                <h2><a href="{{ route('landing.events') }}">{{ $photo->title }}</a></h2>
                @if ($photo->description)
                    <p>{{ \Illuminate\Support\Str::limit($photo->description, 120) }}</p>
                @endif
            </div>
        </div>
    </div>
</div>