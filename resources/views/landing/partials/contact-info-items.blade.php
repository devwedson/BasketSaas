@php
    $phone = $club?->phone ?? config('landing.contact.phone');
    $phoneDisplay = $club?->phone ?? config('landing.contact.phone_display', $phone);
    $email = $club?->email ?? config('landing.contact.email');
    $address = $club?->address ?? config('landing.contact.address');
    $cityLine = $club?->city
        ? trim($club->city.($club->state ? '/'.$club->state : '').($club->country ? ' — '.$club->country : ''))
        : null;
    $hours = config('landing.contact.hours');

    $items = array_values(array_filter([
        $phone ? [
            'icon' => 'images/icon-phone-white.svg',
            'title' => 'Telefone',
            'content' => '<a href="tel:'.preg_replace('/\D/', '', $phone).'">'.e($phoneDisplay).'</a>',
        ] : null,
        $email ? [
            'icon' => 'images/icon-mail-white.svg',
            'title' => 'E-mail',
            'content' => '<a href="mailto:'.e($email).'">'.e($email).'</a>',
        ] : null,
        ($address || $cityLine) ? [
            'icon' => 'images/icon-location-white.svg',
            'title' => 'Endereço',
            'content' => e($address ?: $cityLine),
        ] : null,
        $hours ? [
            'icon' => 'images/icon-clock-accent-secondary.svg',
            'title' => 'Horário',
            'content' => e($hours),
            'light_icon' => true,
        ] : null,
    ]));
@endphp

@if (count($items))
    <div class="about-body-item-list wow fadeInUp" data-wow-delay="0.2s">
        @foreach ($items as $item)
            <div class="about-body-item contact-info-item">
                <div class="icon-box {{ !empty($item['light_icon']) ? 'icon-box-light' : '' }}">
                    <img src="{{ neodunk_asset($item['icon']) }}" alt="{{ $item['title'] }}">
                </div>
                <div class="about-body-item-content">
                    <h3>{{ $item['title'] }}</h3>
                    <p>{!! $item['content'] !!}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif