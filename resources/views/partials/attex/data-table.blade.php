@php
    $tableId = $tableId ?? 'attex-grid-'.uniqid();
    $pageSize = $pageSize ?? 10;
    $gridConfig = [
        'columns' => $columns,
        'data' => $rows,
        'pageSize' => $pageSize,
        'search' => $search ?? true,
        'sort' => $sort ?? true,
    ];
@endphp

<div class="card">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">{{ $title }}</h4>
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $count ?? count($rows) }} registro(s)</span>
        </div>
    </div>
    <div class="p-6">
        <div id="{{ $tableId }}" class="w-full"></div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.AttexGrid) {
        window.AttexGrid.render(@json($tableId), @json($gridConfig));
    }
});
</script>
@endpush