<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GameStatsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private Collection $stats) {}

    public function collection(): Collection
    {
        return $this->stats;
    }

    public function headings(): array
    {
        return ['Jogador', 'MIN', 'PTS', 'REB', 'AST', 'ROU', 'TOC', 'TO', 'FLT', 'FG', '3PT', 'FT'];
    }

    public function map($stat): array
    {
        return [
            $stat->player->name,
            $stat->minutes,
            $stat->points,
            $stat->rebounds,
            $stat->assists,
            $stat->steals,
            $stat->blocks,
            $stat->turnovers,
            $stat->fouls,
            $stat->fg_made.'/'.$stat->fg_attempted,
            $stat->three_made.'/'.$stat->three_attempted,
            $stat->ft_made.'/'.$stat->ft_attempted,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}