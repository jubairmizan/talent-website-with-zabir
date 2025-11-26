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
        Schema::create('creator_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('short_bio')->nullable();
            $table->longText('about_me')->nullable();
            $table->string('banner_image', 500)->nullable();
            $table->string('resume_cv', 500)->nullable();
            $table->string('website_url', 500)->nullable();
            $table->string('facebook_url', 500)->nullable();
            $table->string('instagram_url', 500)->nullable();
            $table->string('twitter_url', 500)->nullable();
            $table->string('linkedin_url', 500)->nullable();
            $table->string('youtube_url', 500)->nullable();
            $table->string('tiktok_url', 500)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('profile_views')->default(0);
            $table->integer('total_likes')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('user_id', 'unique_user_profile');
            $table->index('is_featured', 'idx_featured');
            $table->index('is_active', 'idx_active');
            $table->index('profile_views', 'idx_views');
            $table->index('total_likes', 'idx_likes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_profiles');
    }
};
