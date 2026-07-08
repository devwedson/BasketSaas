<?php

namespace App\Enums;

enum SponsorTier: string
{
    case Master = 'master';
    case Gold = 'gold';
    case Silver = 'silver';
    case Partner = 'partner';

    public function label(): string
    {
        return match ($this) {
            self::Master => 'Master',
            self::Gold => 'Ouro',
            self::Silver => 'Prata',
            self::Partner => 'Apoiador',
        };
    }

    public function sortWeight(): int
    {
        return match ($this) {
            self::Master => 0,
            self::Gold => 1,
            self::Silver => 2,
            self::Partner => 3,
        };
    }
}