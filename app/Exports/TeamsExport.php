<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeamsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private Collection $teams) {}

    public function collection(): Collection
    {
        return $this->teams;
    }

    public function headings(): array
    {
        return ['Nome', 'Categoria', 'Temporada', 'Clube', 'Uniforme', 'Status'];
    }

    public function map($team): array
    {
        return [
            $team->name,
            $team->category,
            $team->season?->name,
            $team->club->name,
            $team->uniform_description,
            $team->is_active ? 'Ativo' : 'Inativo',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}