<a href="{{ route('reports.export', ['type' => 'game-stats', 'format' => 'pdf', 'game_id' => $game->id]) }}" class="btn bg-danger text-white">
    <i class="ri-file-pdf-line me-1"></i> PDF
</a>
<a href="{{ route('reports.export', ['type' => 'game-stats', 'format' => 'excel', 'game_id' => $game->id]) }}" class="btn bg-success text-white">
    <i class="ri-file-excel-line me-1"></i> Excel
</a>