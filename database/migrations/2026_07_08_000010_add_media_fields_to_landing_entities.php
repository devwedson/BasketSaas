<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->text('description')->nullable()->after('logo');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('name');
            $table->text('description')->nullable()->after('category');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->string('opponent_logo')->nullable()->after('opponent');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('opponent_logo');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['logo', 'description']);
        });

        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};