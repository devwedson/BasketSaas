<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TrainingsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private Collection $trainings) {}

    public function collection(): Collection
    {
        return $this->trainings;
    }

    public function headings(): array
    {
        return ['Título', 'Data/Hora', 'Local', 'Time', 'Clube', 'Exercícios'];
    }

    public function map($training): array
    {
        return [
            $training->title,
            $training->scheduled_at->format('d/m/Y H:i'),
            $training->location,
            $training->team?->name,
            $training->club->name,
            $training->exercises,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}