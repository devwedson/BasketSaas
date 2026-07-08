<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('logo');
            $table->string('contact_image')->nullable()->after('cover_image');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('logo');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('opponent_logo');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });

        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'contact_image']);
        });
    }
};