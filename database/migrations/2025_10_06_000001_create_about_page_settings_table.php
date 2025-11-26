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
        Schema::create('about_page_settings', function (Blueprint $table) {
            $table->id();

            // Hero Section
            $table->string('hero_title')->default('Over Brug Kreativo');
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_button_text')->default('Word Lid van Onze Community');

            // Mission Section
            $table->string('mission_title')->default('Onze Missie');
            $table->text('mission_description_1')->nullable();
            $table->text('mission_description_2')->nullable();
            $table->string('mission_image_url')->nullable();

            // Statistics
            $table->string('stat_talents_count')->default('500+');
            $table->string('stat_talents_label')->default('Geregistreerde Talenten');
            $table->string('stat_projects_count')->default('1,200+');
            $table->string('stat_projects_label')->default('Voltooide Projecten');

            // Values Section
            $table->string('values_section_title')->default('Onze Waarden');
            $table->text('values_section_subtitle')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_settings');
    }
};
