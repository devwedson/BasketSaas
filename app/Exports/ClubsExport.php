<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClubsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private Collection $clubs) {}

    public function collection(): Collection
    {
        return $this->clubs;
    }

    public function headings(): array
    {
        return ['Nome', 'Cidade', 'Estado', 'E-mail', 'Telefone', 'Status'];
    }

    public function map($club): array
    {
        return [
            $club->name,
            $club->city,
            $club->state,
            $club->email,
            $club->phone,
            $club->is_active ? 'Ativo' : 'Inativo',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}