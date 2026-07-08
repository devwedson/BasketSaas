<div class="flex flex-col gap-4 lg:flex-row lg:justify-between lg:items-center mb-6">
    <div class="flex items-center gap-4 min-w-0">
        @if (!empty($media))
            <div class="shrink-0">{!! $media !!}</div>
        @endif
        <div class="min-w-0">
            <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">{{ $title }}</h4>
            @if (!empty($subtitle))
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-start lg:justify-end gap-2 shrink-0">
        @if (!empty($actionsView))
            @include($actionsView, $actionsData ?? [])
        @elseif (!empty($actions))
            {!! $actions !!}
        @endif
        @if (!empty($editUrl))
            <a href="{{ $editUrl }}" class="btn bg-primary text-white"><i class="ri-pencil-line me-1"></i> Editar</a>
        @endif
        @if (!empty($backUrl))
            <a href="{{ $backUrl }}" class="btn bg-light text-dark dark:bg-gray-700 dark:text-gray-200"><i class="ri-arrow-left-line me-1"></i> Voltar</a>
        @endif
    </div>
</div>