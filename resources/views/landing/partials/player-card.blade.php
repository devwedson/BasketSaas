@include('landing.partials.team-member', [
    'name' => $player->name,
    'photo' => player_photo_url($player, 'images/team-'.((($index ?? 0) % 8) + 1).'.jpg'),
    'subtitle' => trim(collect([
        $player->number ? '#'.$player->number : null,
        $player->position?->label(),
        $player->team?->name,
    ])->filter()->implode(' · ')),
    'delay' => $delay ?? null,
    'link' => route('landing.team'),
])