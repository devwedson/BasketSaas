<?php

namespace App\Providers;

use App\Services\LandingDataService;
use App\Services\LandingSettingsService;
use App\Services\SmtpSettingsService;
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
            if (Schema::hasTable('settings')) {
                app(SmtpSettingsService::class)->applyToConfig();
                app(LandingSettingsService::class)->applyToConfig();
            }
        } catch (\Throwable) {
            // Ignora falha de conexão durante migrate, cache:clear, etc.
        }

        View::composer(['landing.partials.header', 'landing.partials.footer', 'landing.partials.head'], function ($view) {
            if (! $view->offsetExists('club')) {
                $view->with('club', app(LandingDataService::class)->featuredClub());
            }
        });
    }
}
