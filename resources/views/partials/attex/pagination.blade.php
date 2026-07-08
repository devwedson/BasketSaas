@if (isset($paginator) && $paginator->hasPages())
    <div class="mt-4">
        {{ $paginator->links('partials.attex.pagination-links') }}
    </div>
@endif