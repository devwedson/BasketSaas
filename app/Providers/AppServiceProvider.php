<?php

namespace App\Providers;

use App\Services\LandingDataService;
use App\Services\LandingSettingsService;
use App\Services\PaymentSettingsService;
use App\Services\SmtpSettingsService;
use App\Services\UploadStorageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale(config('app.locale', 'pt_BR'));

        try {
            $uploads = app(UploadStorageService::class);
            $uploads->ensureUploadRoot();

            if (Schema::hasTable('settings')) {
                app(SmtpSettingsService::class)->applyToConfig();
                app(LandingSettingsService::class)->applyToConfig();
                app(PaymentSettingsService::class)->applyToConfig();

                if ($uploads->shouldPublishLegacyUploads()) {
                    $uploads->publishLegacyUploads();
                }
            }
        } catch (\Throwable) {
            // Ignora falha de conexão durante migrate, cache:clear, etc.
        }

        View::composer([
            'landing.partials.header',
            'landing.partials.footer',
            'landing.partials.head',
            'landing.partials.sponsors-section',
            'landing.partials.footer-sponsors',
        ], function ($view) {
            $landing = app(LandingDataService::class);
            $club = $view->offsetExists('club') ? $view->offsetGet('club') : $landing->featuredClub();

            if (! $view->offsetExists('club')) {
                $view->with('club', $club);
            }

            if (! $view->offsetExists('sponsors')) {
                $view->with('sponsors', $landing->sponsors($club));
            }
        });
    }
}
