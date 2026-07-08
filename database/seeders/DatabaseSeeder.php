<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Enums\PlayerPosition;
use App\Enums\StaffRole;
use App\Enums\UserRole;
use App\Models\InscriptionPayment;
use App\Models\Club;
use App\Models\Game;
use App\Models\GameStat;
use App\Models\Player;
use App\Enums\SponsorTier;
use App\Models\Season;
use App\Models\Sponsor;
use App\Models\Staff;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@basketsaas.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::SuperAdmin,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $club = Club::query()->updateOrCreate(
            ['slug' => 'clube-exemplo'],
            [
                'name' => 'Neodunk Basquete SP',
                'logo' => null,
                'description' => 'O Neodunk Basquete SP é referência em formação de atletas na capital paulista. Com categorias de base e equipes adultas, unimos técnica, preparação física e competição real para desenvolver jogadores completos dentro e fora de quadra.',
                'email' => 'contato@neodunksp.com.br',
                'phone' => '(11) 3456-7890',
                'address' => 'Av. Paulista, 1500 — Bela Vista',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'Brasil',
                'is_active' => true,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'clube@basketsaas.com'],
            [
                'name' => 'Gestor do Clube',
                'password' => Hash::make('password'),
                'role' => UserRole::Club,
                'club_id' => $club->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $coachUser = User::query()->updateOrCreate(
            ['email' => 'treinador@basketsaas.com'],
            [
                'name' => 'Treinador Principal',
                'password' => Hash::make('password'),
                'role' => UserRole::Coach,
                'club_id' => $club->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $season = Season::query()->updateOrCreate(
            ['club_id' => $club->id, 'name' => '2026'],
            [
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'is_current' => true,
            ]
        );

        $teamsData = [
            [
                'name' => 'Sub-18 Masculino',
                'category' => 'Sub-18',
                'logo' => 'images/team-logo-1.png',
                'description' => 'Formação competitiva para atletas de 16 a 18 anos, com foco em tática avançada e preparação para ligas estaduais.',
                'uniform_description' => 'Camiseta branca, short azul marinho',
            ],
            [
                'name' => 'Sub-16 Masculino',
                'category' => 'Sub-16',
                'logo' => 'images/team-logo-2.png',
                'description' => 'Desenvolvimento técnico e físico para jovens atletas em fase de consolidação dos fundamentos.',
                'uniform_description' => 'Camiseta laranja, short preto',
            ],
            [
                'name' => 'Sub-14 Misto',
                'category' => 'Sub-14',
                'logo' => 'images/team-logo-3.png',
                'description' => 'Programa de iniciação competitiva com ênfase em fundamentos, disciplina e trabalho em equipe.',
                'uniform_description' => 'Camiseta verde, short branco',
            ],
            [
                'name' => 'Adulto Masculino',
                'category' => 'Adulto',
                'logo' => 'images/team-logo-4.png',
                'description' => 'Equipe sênior que disputa campeonatos regionais e torneios amistosos ao longo da temporada.',
                'uniform_description' => 'Camiseta preta, detalhes dourados',
            ],
        ];

        $teams = collect();
        foreach ($teamsData as $data) {
            $teams->push(Team::query()->updateOrCreate(
                ['club_id' => $club->id, 'name' => $data['name']],
                array_merge($data, ['season_id' => $season->id, 'is_active' => true])
            ));
        }

        $mainTeam = $teams->first();

        $playersData = [
            ['name' => 'Lucas Silva', 'number' => 7, 'position' => PlayerPosition::PointGuard, 'photo' => 'images/team-1.jpg', 'team' => 'Sub-18 Masculino'],
            ['name' => 'Pedro Santos', 'number' => 10, 'position' => PlayerPosition::ShootingGuard, 'photo' => 'images/team-2.jpg', 'team' => 'Sub-18 Masculino'],
            ['name' => 'João Oliveira', 'number' => 23, 'position' => PlayerPosition::Center, 'photo' => 'images/team-3.jpg', 'team' => 'Sub-18 Masculino'],
            ['name' => 'Rafael Costa', 'number' => 5, 'position' => PlayerPosition::SmallForward, 'photo' => 'images/team-4.jpg', 'team' => 'Sub-16 Masculino'],
            ['name' => 'Mateus Alves', 'number' => 11, 'position' => PlayerPosition::PowerForward, 'photo' => 'images/team-5.jpg', 'team' => 'Sub-16 Masculino'],
            ['name' => 'Bruno Ferreira', 'number' => 3, 'position' => PlayerPosition::PointGuard, 'photo' => 'images/team-6.jpg', 'team' => 'Sub-14 Misto'],
            ['name' => 'Thiago Rocha', 'number' => 15, 'position' => PlayerPosition::ShootingGuard, 'photo' => 'images/team-7.jpg', 'team' => 'Sub-14 Misto'],
            ['name' => 'Diego Martins', 'number' => 33, 'position' => PlayerPosition::Center, 'photo' => 'images/team-8.jpg', 'team' => 'Adulto Masculino'],
            ['name' => 'Felipe Nunes', 'number' => 8, 'position' => PlayerPosition::SmallForward, 'photo' => 'images/author-1.jpg', 'team' => 'Adulto Masculino'],
            ['name' => 'André Lima', 'number' => 21, 'position' => PlayerPosition::PowerForward, 'photo' => 'images/author-2.jpg', 'team' => 'Adulto Masculino'],
        ];

        foreach ($playersData as $data) {
            $team = $teams->firstWhere('name', $data['team']) ?? $mainTeam;

            Player::query()->updateOrCreate(
                ['club_id' => $club->id, 'name' => $data['name']],
                [
                    'team_id' => $team->id,
                    'number' => $data['number'],
                    'position' => $data['position'],
                    'photo' => $data['photo'],
                    'height_cm' => rand(170, 205),
                    'weight_kg' => rand(65, 95),
                    'is_active' => true,
                ]
            );
        }

        $staffData = [
            ['name' => 'Carlos Mendes', 'role' => StaffRole::Coach, 'photo' => 'images/team-1.jpg', 'team' => 'Sub-18 Masculino', 'email' => 'treinador@basketsaas.com', 'user_id' => $coachUser->id],
            ['name' => 'Ana Paula Ribeiro', 'role' => StaffRole::Assistant, 'photo' => 'images/team-2.jpg', 'team' => 'Sub-16 Masculino'],
            ['name' => 'Roberto Dias', 'role' => StaffRole::PhysicalTrainer, 'photo' => 'images/team-3.jpg', 'team' => 'Adulto Masculino'],
            ['name' => 'Mariana Souza', 'role' => StaffRole::Physiotherapist, 'photo' => 'images/team-4.jpg', 'team' => null],
        ];

        foreach ($staffData as $data) {
            $team = $data['team'] ? $teams->firstWhere('name', $data['team']) : null;

            $staff = Staff::query()->updateOrCreate(
                ['club_id' => $club->id, 'name' => $data['name']],
                [
                    'team_id' => $team?->id,
                    'role' => $data['role'],
                    'photo' => $data['photo'],
                    'email' => $data['email'] ?? Str::slug($data['name']).'@neodunksp.com.br',
                    'user_id' => $data['user_id'] ?? null,
                    'is_active' => true,
                ]
            );

            if (($data['user_id'] ?? null) === $coachUser->id) {
                InscriptionPayment::query()->updateOrCreate(
                    ['user_id' => $coachUser->id, 'staff_id' => $staff->id],
                    [
                        'club_id' => $club->id,
                        'amount' => 150,
                        'currency' => 'BRL',
                        'status' => PaymentStatus::Approved,
                        'paid_at' => now(),
                    ]
                );
            }
        }

        $trainingsData = [
            ['title' => 'Treino Tático — Defesa em Zona', 'team' => 'Sub-18 Masculino', 'days' => 2],
            ['title' => 'Preparação Física e Arremessos', 'team' => 'Sub-16 Masculino', 'days' => 4],
            ['title' => 'Fundamentos e Transição', 'team' => 'Sub-14 Misto', 'days' => 6],
            ['title' => 'Scrimmage Pré-Campeonato', 'team' => 'Adulto Masculino', 'days' => 9],
        ];

        foreach ($trainingsData as $data) {
            $team = $teams->firstWhere('name', $data['team']) ?? $mainTeam;

            Training::query()->updateOrCreate(
                ['club_id' => $club->id, 'title' => $data['title']],
                [
                    'team_id' => $team->id,
                    'scheduled_at' => now()->addDays($data['days'])->setTime(19, 0),
                    'location' => 'Ginásio Neodunk — São Paulo',
                    'exercises' => 'Aquecimento, fundamentos, tática coletiva e scrimmage',
                ]
            );
        }

        $gamesData = [
            [
                'opponent' => 'Rivals BC',
                'opponent_logo' => 'images/team-logo-5.png',
                'team' => 'Sub-18 Masculino',
                'days' => 7,
                'home_score' => null,
                'away_score' => null,
                'location' => 'Arena Central — São Paulo',
            ],
            [
                'opponent' => 'Thunder Hoops',
                'opponent_logo' => 'images/team-logo-6.png',
                'team' => 'Adulto Masculino',
                'days' => 14,
                'home_score' => null,
                'away_score' => null,
                'location' => 'Ginásio Municipal',
            ],
            [
                'opponent' => 'Capital Stars',
                'opponent_logo' => 'images/team-logo-2.png',
                'team' => 'Sub-18 Masculino',
                'days' => -10,
                'home_score' => 72,
                'away_score' => 68,
                'location' => 'Arena Central — São Paulo',
            ],
            [
                'opponent' => 'West Side Ballers',
                'opponent_logo' => 'images/team-logo-3.png',
                'team' => 'Sub-16 Masculino',
                'days' => -18,
                'home_score' => 58,
                'away_score' => 61,
                'location' => 'Ginásio Neodunk',
            ],
            [
                'opponent' => 'Metro Dunkers',
                'opponent_logo' => 'images/team-logo-4.png',
                'team' => 'Adulto Masculino',
                'days' => -25,
                'home_score' => 81,
                'away_score' => 77,
                'location' => 'Centro Esportivo Paulista',
            ],
        ];

        foreach ($gamesData as $data) {
            $team = $teams->firstWhere('name', $data['team']) ?? $mainTeam;

            $game = Game::query()->updateOrCreate(
                ['club_id' => $club->id, 'opponent' => $data['opponent'], 'team_id' => $team->id],
                [
                    'opponent_logo' => $data['opponent_logo'],
                    'scheduled_at' => now()->addDays($data['days'])->setTime(20, 0),
                    'location' => $data['location'],
                    'home_score' => $data['home_score'],
                    'away_score' => $data['away_score'],
                    'is_home' => true,
                ]
            );

            if ($data['home_score'] !== null) {
                $seedPlayers = Player::query()->where('team_id', $team->id)->limit(3)->get();
                $sampleStats = [
                    ['minutes' => 32, 'points' => 18, 'rebounds' => 4, 'assists' => 7, 'steals' => 2, 'blocks' => 0],
                    ['minutes' => 28, 'points' => 14, 'rebounds' => 3, 'assists' => 2, 'steals' => 1, 'blocks' => 0],
                    ['minutes' => 30, 'points' => 22, 'rebounds' => 11, 'assists' => 1, 'steals' => 0, 'blocks' => 3],
                ];

                foreach ($seedPlayers as $index => $player) {
                    $stats = $sampleStats[$index] ?? ['minutes' => 15, 'points' => 6, 'rebounds' => 2, 'assists' => 1, 'steals' => 0, 'blocks' => 0];

                    GameStat::query()->updateOrCreate(
                        ['game_id' => $game->id, 'player_id' => $player->id],
                        array_merge($stats, [
                            'turnovers' => 2,
                            'fouls' => 3,
                            'fg_made' => 5,
                            'fg_attempted' => 10,
                            'three_made' => 1,
                            'three_attempted' => 3,
                            'ft_made' => 2,
                            'ft_attempted' => 3,
                        ])
                    );
                }
            }
        }

        $sponsorsData = [
            ['name' => 'Arena Sports', 'tier' => SponsorTier::Master, 'logo' => 'images/company-logo-1.svg', 'website' => 'https://example.com', 'contract_amount' => 50000, 'sort_order' => 0],
            ['name' => 'FitPro Nutrition', 'tier' => SponsorTier::Gold, 'logo' => 'images/company-logo-2.svg', 'website' => 'https://example.com', 'contract_amount' => 25000, 'sort_order' => 10],
            ['name' => 'Basquete Store', 'tier' => SponsorTier::Gold, 'logo' => 'images/company-logo-3.svg', 'contract_amount' => 20000, 'sort_order' => 11],
            ['name' => 'Clínica Ortosport', 'tier' => SponsorTier::Silver, 'logo' => 'images/company-logo-4.svg', 'contract_amount' => 10000, 'sort_order' => 20],
            ['name' => 'Transporte Rápido SP', 'tier' => SponsorTier::Partner, 'logo' => 'images/company-logo-5.svg', 'sort_order' => 30],
            ['name' => 'AguaViva', 'tier' => SponsorTier::Partner, 'logo' => 'images/company-logo-6.svg', 'sort_order' => 31],
        ];

        foreach ($sponsorsData as $data) {
            Sponsor::query()->updateOrCreate(
                ['club_id' => $club->id, 'name' => $data['name']],
                [
                    'logo' => $data['logo'],
                    'website' => $data['website'] ?? null,
                    'tier' => $data['tier'],
                    'contract_amount' => $data['contract_amount'] ?? null,
                    'starts_at' => now()->startOfYear(),
                    'ends_at' => now()->endOfYear(),
                    'sort_order' => $data['sort_order'],
                    'show_on_landing' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}