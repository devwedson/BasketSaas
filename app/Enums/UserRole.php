<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Club = 'club';
    case Coach = 'coach';
    case Assistant = 'assistant';
    case Player = 'player';
    case Guardian = 'guardian';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Administrador',
            self::Club => 'Clube',
            self::Coach => 'Treinador',
            self::Assistant => 'Auxiliar',
            self::Player => 'Atleta',
            self::Guardian => 'Responsável',
        };
    }
}