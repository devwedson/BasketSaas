@php
    $landingBlog = app(\App\Services\LandingDataService::class);
    $clubForBlog = $club ?? $landingBlog->featuredClub();
    $trainings = $trainings ?? $landingBlog->trainings($clubForBlog, 3);
    $recentGames = $recentGames ?? $landingBlog->recentGames($clubForBlog, 3);

    $posts = collect();
    $postIndex = 0;

    foreach ($trainings as $training) {
        $posts->push([
            'image' => neodunk_asset('images/post-'.(($postIndex % 6) + 1).'.jpg'),
            'tag' => $training->team?->name ?? 'Treino',
            'tagLink' => route('landing.programs'),
            'title' => $training->title,
            'link' => route('landing.blog'),
        ]);
        $postIndex++;
        if ($posts->count() >= 3) {
            break;
        }
    }

    if ($posts->count() < 3) {
        foreach ($recentGames as $game) {
            $posts->push([
                'image' => game_cover_image_url($game, $postIndex),
                'tag' => 'Resultado',
                'tagLink' => route('landing.matches'),
                'title' => trim(($game->team?->name ?? 'Time').' '.($game->home_score !== null ? $game->home_score.' x '.$game->away_score : 'vs').' '.$game->opponent),
                'link' => route('landing.matches'),
            ]);
            $postIndex++;
            if ($posts->count() >= 3) {
                break;
            }
        }
    }

    if ($posts->isEmpty()) {
        $posts = collect([
            [
                'image' => neodunk_asset('images/post-1.jpg'),
                'tag' => 'Formação',
                'tagLink' => route('landing.programs'),
                'title' => '5 dicas essenciais para aprimorar seu arremesso e aumentar a pontuação',
                'link' => route('landing.blog'),
            ],
            [
                'image' => neodunk_asset('images/post-2.jpg'),
                'tag' => 'Fundamentos',
                'tagLink' => route('landing.programs'),
                'title' => 'Dominando os fundamentos: habilidades que todo jogador de basquete deve conhecer',
                'link' => route('landing.blog'),
            ],
            [
                'image' => neodunk_asset('images/post-3.jpg'),
                'tag' => 'Base',
                'tagLink' => route('landing.programs'),
                'title' => 'Desenvolvimento juvenil: construindo confiança e disciplina desde cedo',
                'link' => route('landing.blog'),
            ],
        ]);
    }
@endphp

<div class="our-blog">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <span class="section-sub-title wow fadeInUp">Últimas Notícias</span>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Treinos, estratégias e destaques dos nossos atletas</h2>
                </div>
            </div>
        </div>

        <div class="row post-item-list">
            @foreach ($posts as $post)
                <div class="col-xl-4 col-md-6">
                    @include('landing.partials.post-item', [
                        'active' => $loop->first,
                        'delay' => ($loop->index * 0.2).'s',
                        'image' => $post['image'],
                        'tag' => $post['tag'],
                        'tagLink' => $post['tagLink'],
                        'title' => $post['title'],
                        'link' => $post['link'],
                    ])
                </div>
            @endforeach
        </div>
    </div>
</div>