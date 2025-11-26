<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('ONTDEK CREATORS OP CURAÇAO');
            $table->string('hero_subtitle')->default('Jouw brug naar lokaal talent');
            $table->string('hero_video_url')->nullable();
            $table->string('search_placeholder_text')->default('Zoek hier naar creators...');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
