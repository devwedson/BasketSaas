<?php

return [

    'assets' => [
        'prefix' => env('NEODUNK_ASSETS_PATH', 'neodunk'),
    ],

    'brand' => [
        'name' => env('LANDING_BRAND_NAME', env('APP_NAME', 'BasketSaas')),
        'tagline' => env('LANDING_TAGLINE', 'Gestão profissional de basquete para clubes, times e atletas.'),
        'logo' => env('LANDING_LOGO', 'images/logo.svg'),
        'favicon' => env('LANDING_FAVICON', 'images/favicon.png'),
    ],

    'contact' => [
        'phone' => env('LANDING_PHONE'),
        'phone_display' => env('LANDING_PHONE_DISPLAY'),
        'email' => env('LANDING_EMAIL'),
        'address' => env('LANDING_ADDRESS'),
        'hours' => env('LANDING_HOURS', 'Segunda a Sábado: 8h às 21h'),
    ],

    'social' => [
        'facebook' => env('LANDING_SOCIAL_FACEBOOK'),
        'instagram' => env('LANDING_SOCIAL_INSTAGRAM'),
        'linkedin' => env('LANDING_SOCIAL_LINKEDIN'),
        'youtube' => env('LANDING_SOCIAL_YOUTUBE'),
    ],

    'featured_club_slug' => env('LANDING_CLUB_SLUG', 'clube-exemplo'),

    'cta' => [
        'header_label' => env('LANDING_CTA_HEADER', 'Entrar'),
        'header_route' => env('LANDING_CTA_HEADER_ROUTE', 'login'),
    ],

    'footer' => [
        'newsletter_title' => env('LANDING_FOOTER_NEWSLETTER', 'Receba novidades exclusivas sobre jogos, eventos e o clube!'),
    ],

    'images' => [
        'about_secondary' => 'images/about-us-image-2.jpg',
        'testimonial' => 'images/testimonial-image.jpg',
        'faq' => 'images/faq-image.jpg',
        'contact' => 'images/contact-us-image.jpg',
    ],

    'sections' => [],

    'testimonials' => [
        [
            'quote' => 'Treinar neste clube elevou completamente meu jogo. A comissão técnica foca em fundamentos, estratégia e força mental — isso me deixou muito mais confiante em quadra.',
        ],
        [
            'quote' => 'Adoro fazer parte deste clube. Cada sessão é desafiadora e bem organizada. Os treinadores explicam tudo com clareza e sempre nos incentivam a evoluir.',
        ],
        [
            'quote' => 'A estrutura do clube une treino de qualidade, espírito de equipe e oportunidades reais de competição. Foi o melhor passo da minha carreira no basquete.',
        ],
    ],

    'faqs' => [
        [
            'category' => 'Perguntas Gerais',
            'id' => 'faq_geral',
            'items' => [
                [
                    'question' => 'Preciso ter experiência prévia em basquete para me inscrever?',
                    'answer' => 'Não é necessária experiência prévia. O clube recebe iniciantes, intermediários e avançados. Os programas são estruturados por faixa etária e nível, garantindo evolução progressiva com acompanhamento técnico.',
                ],
                [
                    'question' => 'Quais categorias estão disponíveis?',
                    'answer' => 'Trabalhamos com categorias de formação (Sub-12, Sub-14, Sub-16, Sub-18) e equipes adultas. Cada time possui treinos específicos, calendário de jogos e comissão técnica dedicada.',
                ],
                [
                    'question' => 'Como faço para entrar em contato com o clube?',
                    'answer' => 'Você pode usar o formulário de contato, ligar para o telefone informado no rodapé ou enviar um e-mail. Nossa equipe responde em até 24 horas úteis.',
                ],
            ],
        ],
        [
            'category' => 'Treinos e Programas',
            'id' => 'faq_treinos',
            'items' => [
                [
                    'question' => 'Com que frequência acontecem os treinos?',
                    'answer' => 'A frequência varia por categoria: equipes de formação treinam de 2 a 4 vezes por semana; categorias competitivas podem ter até 5 sessões semanais, incluindo preparação física e tática.',
                ],
                [
                    'question' => 'Os treinos incluem preparação física?',
                    'answer' => 'Sim. Todos os programas combinam fundamentos técnicos, condicionamento físico, tática coletiva e trabalho mental, sempre adaptados à idade e ao nível do atleta.',
                ],
            ],
        ],
        [
            'category' => 'Jogos e Competições',
            'id' => 'faq_jogos',
            'items' => [
                [
                    'question' => 'O clube participa de campeonatos oficiais?',
                    'answer' => 'Sim. Nossas equipes disputam ligas regionais e estaduais, além de torneios amistosos ao longo da temporada. O calendário completo fica disponível na página de Jogos.',
                ],
                [
                    'question' => 'Como acompanho os resultados dos jogos?',
                    'answer' => 'Os resultados, placares e estatísticas dos atletas são publicados na landing e gerenciados no painel do clube após cada partida.',
                ],
            ],
        ],
    ],

    'menu' => [
        ['label' => 'Início', 'route' => 'landing'],
        ['label' => 'Sobre', 'route' => 'landing.about'],
        ['label' => 'Programas', 'route' => 'landing.programs'],
        ['label' => 'Jogos', 'route' => 'landing.matches'],
        ['label' => 'Equipes', 'route' => 'landing.team'],
        ['label' => 'Notícias', 'route' => 'landing.blog'],
        ['label' => 'FAQ', 'route' => 'landing.faqs'],
        ['label' => 'Contato', 'route' => 'landing.contact'],
    ],

    'pages' => [
        'index' => [
            'file' => 'index',
            'route' => 'landing',
            'title' => 'Início',
        ],
        'about' => [
            'file' => 'about',
            'route' => 'landing.about',
            'title' => 'Sobre',
        ],
        'contact' => [
            'file' => 'contact',
            'route' => 'landing.contact',
            'title' => 'Contato',
        ],
        'programs' => [
            'file' => 'programs',
            'route' => 'landing.programs',
            'title' => 'Programas',
        ],
        'matches' => [
            'file' => 'matches',
            'route' => 'landing.matches',
            'title' => 'Jogos',
        ],
        'team' => [
            'file' => 'team',
            'route' => 'landing.team',
            'title' => 'Equipes',
        ],
        'blog' => [
            'file' => 'blog',
            'route' => 'landing.blog',
            'title' => 'Blog',
        ],
        'faqs' => [
            'file' => 'faqs',
            'route' => 'landing.faqs',
            'title' => 'FAQ',
        ],
    ],

];