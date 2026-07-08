@php
    $breadcrumbs = $breadcrumbs ?? [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => $title],
    ];
@endphp

<div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6">
    <div>
        <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">{{ $title }}</h4>
        @if (!empty($subtitle))
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <div class="hidden lg:flex items-center gap-2.5 font-semibold">
            @foreach ($breadcrumbs as $index => $crumb)
                @if ($index > 0)
                    <i class="ri-arrow-right-s-line text-base text-slate-400 dark:text-slate-500 rtl:rotate-180"></i>
                @endif
                @if (!empty($crumb['url']) && $index < count($breadcrumbs) - 1)
                    <a href="{{ $crumb['url'] }}" class="text-sm font-medium text-slate-700 dark:text-slate-400">{{ $crumb['label'] }}</a>
                @else
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-400" @if($index === count($breadcrumbs) - 1) aria-current="page" @endif>{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </div>

        @if (!empty($actionUrl))
            <a href="{{ $actionUrl }}" class="btn bg-primary text-white">
                @if (!empty($actionIcon))<i class="{{ $actionIcon }} me-1"></i>@endif
                {{ $actionLabel ?? 'Novo' }}
            </a>
        @endif

        @if (!empty($actionsView))
            @include($actionsView, $actionsData ?? [])
        @elseif (!empty($actions))
            {!! $actions !!}
        @endif
    </div>
</div>