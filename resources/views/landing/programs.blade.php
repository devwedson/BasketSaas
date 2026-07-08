@extends('layouts.neodunk.app')

@section('content')
@include('landing.partials.page-header', ['title' => 'Programas'])

<div class="page-programs">
    <div class="container">
        <div class="row">
            @forelse ($teams as $team)
                <div class="col-xl-3 col-md-6">
                    <div class="program-item wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 }}s">
                        <div class="program-item-image">
                            <a href="{{ route('landing.team') }}" data-cursor-text="Ver">
                                <figure>
                                    <img src="{{ team_program_image_url($team, $loop->index) }}" alt="{{ $team->name }}">
                                </figure>
                            </a>
                        </div>
                        <div class="program-item-body">
                            <div class="program-item-content">
                                <h2><a href="{{ route('landing.team') }}">{{ $team->name }}</a></h2>
                                <p>{{ $team->description ?? 'Categoria '.($team->category ?? 'formação').' com '.($team->players_count ?? 0).' atletas.' }}</p>
                            </div>
                            <div class="program-readmore-btn">
                                <a href="{{ route('landing.team') }}" class="readmore-btn">Ver Elenco</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p>Nenhum programa cadastrado ainda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection