<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (! function_exists('neodunk_asset')) {
    function neodunk_asset(string $path = ''): string
    {
        $prefix = trim(config('landing.assets.prefix', 'neodunk'), '/');

        return $path === '' ? asset($prefix) : asset("{$prefix}/".ltrim($path, '/'));
    }
}

if (! function_exists('attex_asset')) {
    function attex_asset(string $path = ''): string
    {
        $prefix = trim(config('attex.assets.prefix', 'attex'), '/');

        return $path === '' ? asset($prefix) : asset("{$prefix}/".ltrim($path, '/'));
    }
}

if (! function_exists('page_title')) {
    function page_title(?string $suffix = null): string
    {
        $name = config('landing.brand.name', config('app.name'));

        return $suffix ? "{$suffix} | {$name}" : "{$name} — ".config('landing.brand.tagline');
    }
}

if (! function_exists('landing_route')) {
    function landing_route(string $routeName): string
    {
        return Route::has($routeName) ? route($routeName) : '#';
    }
}

if (! function_exists('normalize_upload_path')) {
    function normalize_upload_path(?string $path): string
    {
        return ltrim(str_replace('\\', '/', (string) $path), '/');
    }
}

if (! function_exists('is_panel_upload_path')) {
    function is_panel_upload_path(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return true;
        }

        $path = normalize_upload_path($path);

        // Caminhos images/ são assets padrão do Neodunk (seed), não uploads do painel.
        if (str_starts_with($path, 'images/')) {
            return false;
        }

        foreach (['clubs/', 'teams/', 'players/', 'staff/', 'sponsors/', 'games/', 'landing/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('public_upload_exists')) {
    function public_upload_exists(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        return app(\App\Services\UploadStorageService::class)->absolutePathFor($path) !== null;
    }
}

if (! function_exists('is_custom_media_path')) {
    function is_custom_media_path(?string $path): bool
    {
        if (is_panel_upload_path($path)) {
            return true;
        }

        return public_upload_exists($path);
    }
}

if (! function_exists('public_upload_url')) {
    function public_upload_url(string $path): string
    {
        $path = normalize_upload_path($path);

        if (Route::has('media.show')) {
            return route('media.show', ['path' => $path]);
        }

        return asset('storage/'.$path);
    }
}

if (! function_exists('storage_or_asset')) {
    function storage_or_asset(?string $path, string $fallback): string
    {
        if (is_custom_media_path($path)) {
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }

            return public_upload_url($path);
        }

        return neodunk_asset($fallback);
    }
}

if (! function_exists('club_logo_url')) {
    function club_logo_url(?\App\Models\Club $club, string $fallback = 'images/logo.svg'): string
    {
        return storage_or_asset($club?->logo, $fallback);
    }
}

if (! function_exists('team_logo_url')) {
    function team_logo_url(?\App\Models\Team $team, string $fallback = 'images/team-logo-1.png'): string
    {
        return storage_or_asset($team?->logo, $fallback);
    }
}

if (! function_exists('player_photo_url')) {
    function player_photo_url(?\App\Models\Player $player, string $fallback = 'images/team-1.jpg'): string
    {
        return storage_or_asset($player?->photo, $fallback);
    }
}

if (! function_exists('staff_photo_url')) {
    function staff_photo_url(?\App\Models\Staff $staff, string $fallback = 'images/team-2.jpg'): string
    {
        return storage_or_asset($staff?->photo, $fallback);
    }
}

if (! function_exists('game_opponent_logo_url')) {
    function game_opponent_logo_url(?\App\Models\Game $game, string $fallback = 'images/team-logo-2.png'): string
    {
        return storage_or_asset($game?->opponent_logo, $fallback);
    }
}

if (! function_exists('team_program_image_url')) {
    function team_program_image_url(?\App\Models\Team $team, int $index = 0): string
    {
        return team_cover_image_url($team, $index);
    }
}

if (! function_exists('team_cover_image_url')) {
    function team_cover_image_url(?\App\Models\Team $team, int $index = 0): string
    {
        $fallback = 'images/program-image-'.(($index % 4) + 1).'.jpg';

        return storage_or_asset($team?->cover_image, $fallback);
    }
}

if (! function_exists('club_cover_image_url')) {
    function club_cover_image_url(?\App\Models\Club $club, string $fallback = 'images/about-us-image-1.png'): string
    {
        return storage_or_asset($club?->cover_image, $fallback);
    }
}

if (! function_exists('club_contact_image_url')) {
    function club_contact_image_url(?\App\Models\Club $club, string $fallback = 'images/contact-us-image.jpg'): string
    {
        return storage_or_asset($club?->contact_image, $fallback);
    }
}

if (! function_exists('game_cover_image_url')) {
    function game_cover_image_url(?\App\Models\Game $game, int $index = 0): string
    {
        $fallback = 'images/match-highlight-image-'.(($index % 6) + 1).'.jpg';

        return storage_or_asset($game?->cover_image, $fallback);
    }
}

if (! function_exists('landing_brand_logo_url')) {
    function landing_brand_logo_url(?\App\Models\Club $club = null): string
    {
        if (! $club) {
            $club = app(\App\Services\LandingDataService::class)->featuredClub();
        }

        if (is_custom_media_path($club?->logo)) {
            return public_upload_url($club->logo);
        }

        $brandLogo = config('landing.brand.logo', 'images/logo.svg');

        if (is_custom_media_path($brandLogo)) {
            return public_upload_url($brandLogo);
        }

        return neodunk_asset($brandLogo);
    }
}

if (! function_exists('landing_favicon_url')) {
    function landing_favicon_url(?\App\Models\Club $club = null): string
    {
        if (! $club) {
            $club = app(\App\Services\LandingDataService::class)->featuredClub();
        }

        if (is_custom_media_path($club?->logo)) {
            return public_upload_url($club->logo);
        }

        $favicon = config('landing.brand.favicon', 'images/favicon.png');

        if (is_custom_media_path($favicon)) {
            return public_upload_url($favicon);
        }

        return neodunk_asset($favicon);
    }
}

if (! function_exists('sponsor_logo_url')) {
    function sponsor_logo_url(?\App\Models\Sponsor $sponsor, int $index = 0): string
    {
        $fallback = 'images/company-logo-'.(($index % 6) + 1).'.svg';

        return storage_or_asset($sponsor?->logo, $fallback);
    }
}

if (! function_exists('landing_brand_name')) {
    function landing_brand_name(?\App\Models\Club $club = null): string
    {
        if (! $club) {
            $club = app(\App\Services\LandingDataService::class)->featuredClub();
        }

        return $club?->name ?? config('landing.brand.name', config('app.name'));
    }
}

if (! function_exists('landing_placeholders')) {
    function landing_placeholders(?array $stats = null, ?\App\Models\Club $club = null): array
    {
        if ($stats === null || $club === null) {
            $landingData = app(\App\Services\LandingDataService::class);
            $club = $club ?? $landingData->featuredClub();
            $stats = $stats ?? $landingData->stats($club);
        }

        return [
            '{players}' => (string) ($stats['players'] ?? 0),
            '{teams}' => (string) ($stats['teams'] ?? 0),
            '{games}' => (string) ($stats['games'] ?? 0),
            '{club}' => landing_brand_name($club),
        ];
    }
}

if (! function_exists('landing_section')) {
    function landing_section(string $section, string $key, ?string $default = null, ?array $stats = null, ?\App\Models\Club $club = null): string
    {
        $value = config("landing.sections.{$section}.{$key}");

        if (blank($value)) {
            $value = config("landing_sections.{$section}.{$key}", $default ?? '');
        }

        return strtr((string) $value, landing_placeholders($stats, $club));
    }
}

if (! function_exists('landing_image')) {
    function landing_image(string $key, ?string $fallback = null): string
    {
        $fallback = $fallback ?? config("landing.images.{$key}", "images/{$key}.jpg");
        $path = config("landing.images.{$key}");

        return storage_or_asset($path, $fallback);
    }
}

if (! function_exists('attex_status_badge_html')) {
    function attex_status_badge_html(bool $active, ?string $activeLabel = null, ?string $inactiveLabel = null): string
    {
        return view('partials.attex.status-badge', [
            'active' => $active,
            'activeLabel' => $activeLabel,
            'inactiveLabel' => $inactiveLabel,
        ])->render();
    }
}

if (! function_exists('attex_row_actions_html')) {
    function attex_row_actions_html(?string $showUrl = null, ?string $editUrl = null, ?string $deleteUrl = null, ?string $deleteConfirm = null, ?string $deleteTitle = null): string
    {
        return view('partials.attex.row-actions-html', [
            'showUrl' => $showUrl,
            'editUrl' => $editUrl,
            'deleteUrl' => $deleteUrl,
            'deleteConfirm' => $deleteConfirm,
            'deleteTitle' => $deleteTitle,
        ])->render();
    }
}