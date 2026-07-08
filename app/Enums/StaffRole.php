<?php

namespace App\Enums;

enum StaffRole: string
{
    case Coach = 'coach';
    case Assistant = 'assistant';
    case PhysicalTrainer = 'physical_trainer';
    case Physiotherapist = 'physiotherapist';

    public function label(): string
    {
        return match ($this) {
            self::Coach => 'Técnico',
            self::Assistant => 'Auxiliar',
            self::PhysicalTrainer => 'Preparador Físico',
            self::Physiotherapist => 'Fisioterapeuta',
        };
    }
}