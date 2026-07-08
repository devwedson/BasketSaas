<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlayersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private Collection $players) {}

    public function collection(): Collection
    {
        return $this->players;
    }

    public function headings(): array
    {
        return ['Nome', 'Número', 'Posição', 'Time', 'Clube', 'Altura (cm)', 'Peso (kg)', 'Status'];
    }

    public function map($player): array
    {
        return [
            $player->name,
            $player->number,
            $player->position?->label(),
            $player->team?->name,
            $player->club->name,
            $player->height_cm,
            $player->weight_kg,
            $player->is_active ? 'Ativo' : 'Inativo',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}