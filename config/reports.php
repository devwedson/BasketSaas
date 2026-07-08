<?php

return [

    'types' => [
        [
            'type' => 'players',
            'name' => 'Jogadores',
            'icon' => 'ri-user-star-line',
            'description' => 'Lista completa de atletas',
            'roles' => ['super_admin', 'club', 'coach', 'assistant'],
        ],
        [
            'type' => 'teams',
            'name' => 'Times',
            'icon' => 'ri-team-line',
            'description' => 'Times e categorias',
            'roles' => ['super_admin', 'club', 'coach', 'assistant'],
        ],
        [
            'type' => 'trainings',
            'name' => 'Treinos',
            'icon' => 'ri-basketball-line',
            'description' => 'Agenda de treinos',
            'roles' => ['super_admin', 'club', 'coach', 'assistant'],
        ],
        [
            'type' => 'games',
            'name' => 'Jogos',
            'icon' => 'ri-trophy-line',
            'description' => 'Jogos e placares',
            'roles' => ['super_admin', 'club', 'coach', 'assistant'],
        ],
        [
            'type' => 'clubs',
            'name' => 'Clubes',
            'icon' => 'ri-building-2-line',
            'description' => 'Todos os clubes cadastrados',
            'roles' => ['super_admin'],
        ],
    ],

];