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
        Schema::create('creator_talent_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('talent_category_id')->constrained()->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            
            $table->unique(['creator_profile_id', 'talent_category_id'], 'unique_creator_category');
            $table->index('creator_profile_id', 'idx_creator');
            $table->index('talent_category_id', 'idx_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_talent_categories');
    }
};
