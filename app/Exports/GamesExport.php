<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GamesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private Collection $games) {}

    public function collection(): Collection
    {
        return $this->games;
    }

    public function headings(): array
    {
        return ['Adversário', 'Data/Hora', 'Local', 'Placar', 'Time', 'Clube', 'Mando'];
    }

    public function map($game): array
    {
        $score = isset($game->home_score)
            ? $game->home_score.' x '.$game->away_score
            : '-';

        return [
            $game->opponent,
            $game->scheduled_at->format('d/m/Y H:i'),
            $game->location,
            $score,
            $game->team?->name,
            $game->club->name,
            $game->is_home ? 'Casa' : 'Fora',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}