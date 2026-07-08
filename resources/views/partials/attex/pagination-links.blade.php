@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginação" class="flex items-center justify-between gap-3">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            @if ($paginator->firstItem())
                Exibindo {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }}
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="btn btn-sm bg-light/60 text-gray-400 dark:bg-gray-700/60 dark:text-gray-500 cursor-not-allowed">Anterior</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200">Anterior</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-gray-400 dark:text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="btn btn-sm bg-primary text-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200">Próxima</a>
            @else
                <span class="btn btn-sm bg-light/60 text-gray-400 dark:bg-gray-700/60 dark:text-gray-500 cursor-not-allowed">Próxima</span>
            @endif
        </div>
    </nav>
@endif