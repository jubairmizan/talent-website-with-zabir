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
        Schema::create('contact_page_settings', function (Blueprint $table) {
            $table->id();

            // Hero Section
            $table->string('hero_title')->default('Contact Ons');
            $table->text('hero_subtitle')->nullable();

            // Form Section
            $table->string('form_section_title')->default('Stuur Ons Een Bericht');
            $table->text('form_section_subtitle')->nullable();
            $table->string('form_button_text')->default('Verstuur Bericht');

            // Success Message
            $table->string('success_title')->default('Bericht Verzonden!');
            $table->text('success_message')->nullable();
            $table->string('success_button_text')->default('Nieuw Bericht Versturen');

            // Contact Information
            $table->string('contact_info_title')->default('Contact Informatie');
            $table->string('contact_address')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('contact_hours')->nullable();

            // FAQ Section
            $table->string('faq_section_title')->default('Veelgestelde Vragen');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_page_settings');
    }
};
