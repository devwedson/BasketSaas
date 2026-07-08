<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscription_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('BRL');
            $table->string('status')->default('pending');
            $table->string('gateway')->default('mercadopago');
            $table->string('preference_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['staff_id', 'status']);
        });

        Schema::table('financial_transactions', function (Blueprint $table) {
            $table->foreignId('staff_id')->nullable()->after('player_id')->constrained('staff')->nullOnDelete();
            $table->foreignId('inscription_payment_id')->nullable()->after('staff_id')->constrained('inscription_payments')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('financial_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('inscription_payment_id');
            $table->dropConstrainedForeignId('staff_id');
        });

        Schema::dropIfExists('inscription_payments');
    }
};