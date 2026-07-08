@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => landing_section('page_blog', 'header_title')])

<div class="page-blog">
    <div class="container">
        <div class="row post-item-list">
            @php $postIndex = 0; @endphp

            @foreach ($trainings as $training)
                <div class="col-xl-4 col-md-6">
                    @include('landing.partials.post-item', [
                        'active' => $postIndex === 0,
                        'delay' => ($postIndex * 0.2).'s',
                        'image' => neodunk_asset('images/post-'.(($postIndex % 6) + 1).'.jpg'),
                        'tag' => $training->team?->name ?? 'Treino',
                        'tagLink' => route('landing.programs'),
                        'title' => $training->title,
                        'link' => route('landing.programs'),
                    ])
                </div>
                @php $postIndex++; @endphp
            @endforeach

            @foreach ($recentGames as $game)
                <div class="col-xl-4 col-md-6">
                    @include('landing.partials.post-item', [
                        'active' => $postIndex === 0,
                        'delay' => ($postIndex * 0.2).'s',
                        'image' => game_cover_image_url($game, $postIndex),
                        'tag' => 'Resultado',
                        'tagLink' => route('landing.matches'),
                        'title' => $game->team?->name.' '.($game->home_score !== null ? $game->home_score.' x '.$game->away_score : 'vs').' '.$game->opponent,
                        'link' => route('landing.matches'),
                    ])
                </div>
                @php $postIndex++; @endphp
            @endforeach

            @if ($postIndex === 0)
                <div class="col-12 text-center py-5">
                    <p>Nenhuma atualização publicada ainda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection