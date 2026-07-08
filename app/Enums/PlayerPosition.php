<?php

namespace App\Enums;

enum PlayerPosition: string
{
    case PointGuard = 'pg';
    case ShootingGuard = 'sg';
    case SmallForward = 'sf';
    case PowerForward = 'pf';
    case Center = 'c';

    public function label(): string
    {
        return match ($this) {
            self::PointGuard => 'Armador',
            self::ShootingGuard => 'Ala-Armador',
            self::SmallForward => 'Ala',
            self::PowerForward => 'Ala-Pivô',
            self::Center => 'Pivô',
        };
    }
}