<div class="post-item {{ !empty($active) ? 'active' : '' }} wow fadeInUp" @if(!empty($delay)) data-wow-delay="{{ $delay }}" @endif>
    <div class="post-item-image">
        <figure>
            <img src="{{ $image }}" alt="{{ $title }}">
        </figure>
    </div>
    <div class="post-item-content-box">
        <div class="post-item-tag">
            <a href="{{ $tagLink ?? '#' }}">{{ $tag }}</a>
        </div>
        <div class="post-item-body">
            <div class="post-item-content">
                <h2><a href="{{ $link ?? '#' }}">{{ $title }}</a></h2>
            </div>
            <div class="post-item-btn">
                <a href="{{ $link ?? '#' }}" class="readmore-btn">Ler Mais</a>
            </div>
        </div>
    </div>
</div>