@php
    $playerTeam = $team ?? $player->team;
    $playerLink = $playerTeam
        ? route('landing.team.show', $playerTeam)
        : route('landing.team');
@endphp

@include('landing.partials.team-member', [
    'name' => $player->name,
    'photo' => player_photo_url($player, 'images/team-'.((($index ?? 0) % 8) + 1).'.jpg'),
    'subtitle' => trim(collect([
        $player->number ? '#'.$player->number : null,
        $player->position?->label(),
        $playerTeam?->name,
    ])->filter()->implode(' · ')),
    'delay' => $delay ?? null,
    'link' => $playerLink,
])