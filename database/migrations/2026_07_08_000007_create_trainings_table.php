<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->dateTime('scheduled_at');
            $table->string('location')->nullable();
            $table->text('exercises')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('training_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->boolean('present')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['training_id', 'player_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_attendance');
        Schema::dropIfExists('trainings');
    }
};