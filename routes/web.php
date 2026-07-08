<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PublicStorageController;
use App\Http\Controllers\SmtpSettingsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubSettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\InscriptionPaymentController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LandingSettingsController;
use App\Http\Controllers\MercadoPagoWebhookController;
use App\Http\Controllers\PaymentSettingsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/mercadopago', [MercadoPagoWebhookController::class, 'handle'])
    ->name('webhooks.mercadopago');

Route::get('/storage/{path}', [PublicStorageController::class, 'show'])
    ->where('path', '.*')
    ->name('storage.fallback');

Route::controller(LandingController::class)->group(function () {
    Route::get('/', 'index')->name('landing');
    Route::get('/sobre', 'about')->name('landing.about');
    Route::get('/contato', 'contact')->name('landing.contact');
    Route::get('/programas', 'programs')->name('landing.programs');
    Route::get('/jogos', 'matches')->name('landing.matches');
    Route::get('/equipe', 'team')->name('landing.team');
    Route::get('/equipe/{team}', 'teamShow')->name('landing.team.show');
    Route::get('/blog', 'blog')->name('landing.blog');
    Route::get('/faq', 'faqs')->name('landing.faqs');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/cadastro', [RegisterController::class, 'create'])->name('register');
    Route::post('/cadastro', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/email/verificar', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verificar/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/reenviar', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');

    Route::middleware('verified')->group(function () {
        Route::get('/inscricao', [InscriptionPaymentController::class, 'checkout'])->name('inscription.checkout');
        Route::get('/inscricao/sucesso', [InscriptionPaymentController::class, 'success'])->name('inscription.success');
        Route::get('/inscricao/falha', [InscriptionPaymentController::class, 'failure'])->name('inscription.failure');
        Route::get('/inscricao/pendente', [InscriptionPaymentController::class, 'pending'])->name('inscription.pending');

        Route::middleware('inscription.paid')->group(function () {
        Route::get('/inscricao/comprovante', [InscriptionPaymentController::class, 'latestReceipt'])->name('inscription.receipt');
        Route::get('/inscricao/pagamentos/{payment}/comprovante', [InscriptionPaymentController::class, 'showReceipt'])->name('inscription.payments.receipt');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::middleware('role:super_admin')->group(function () {
            Route::resource('clubs', ClubController::class);
            Route::get('/configuracoes/smtp', [SmtpSettingsController::class, 'edit'])->name('smtp.settings.edit');
            Route::put('/configuracoes/smtp', [SmtpSettingsController::class, 'update'])->name('smtp.settings.update');
            Route::post('/configuracoes/smtp/teste', [SmtpSettingsController::class, 'test'])->name('smtp.settings.test');
            Route::get('/configuracoes/smtp/preview/ativacao', [SmtpSettingsController::class, 'previewActivation'])->name('smtp.settings.preview.activation');
            Route::get('/configuracoes/smtp/preview/ativacao/frame', [SmtpSettingsController::class, 'previewActivationFrame'])->name('smtp.settings.preview.activation.frame'); // iframe
            Route::get('/configuracoes/landing', [LandingSettingsController::class, 'edit'])->name('landing.settings.edit');
            Route::put('/configuracoes/landing', [LandingSettingsController::class, 'update'])->name('landing.settings.update');
            Route::get('/configuracoes/pagamentos', [PaymentSettingsController::class, 'edit'])->name('payment.settings.edit');
            Route::put('/configuracoes/pagamentos', [PaymentSettingsController::class, 'update'])->name('payment.settings.update');
        });

        Route::middleware('role:club')->group(function () {
            Route::get('/landing-clube', [ClubSettingsController::class, 'edit'])->name('club.settings.edit');
            Route::put('/landing-clube', [ClubSettingsController::class, 'update'])->name('club.settings.update');
        });

        Route::middleware('role:super_admin,club')->group(function () {
            Route::resource('sponsors', SponsorController::class);
        });

        Route::middleware('role:super_admin,club,coach,assistant')->group(function () {
            Route::resource('teams', TeamController::class);
            Route::resource('players', PlayerController::class);
            Route::resource('staff', StaffController::class);
            Route::post('staff/{staff}/acesso', [StaffController::class, 'provisionAccess'])->name('staff.provision-access');
            Route::resource('trainings', TrainingController::class);
            Route::post('trainings/{training}/attendance', [TrainingController::class, 'attendance'])->name('trainings.attendance');
            Route::resource('games', GameController::class);
            Route::post('games/{game}/stats', [GameController::class, 'stats'])->name('games.stats');
            Route::get('/calendario', [CalendarController::class, 'index'])->name('calendar.index');
            Route::get('/relatorios', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/relatorios/{type}/{format}', [ReportController::class, 'export'])->name('reports.export');
        });
        });
    });
});