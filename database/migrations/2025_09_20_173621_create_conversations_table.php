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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('member_id');
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->unsignedBigInteger('blocked_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blocked_by')->references('id')->on('users')->onDelete('set null');
            $table->unique(['creator_id', 'member_id'], 'unique_conversation');
            $table->index('creator_id', 'idx_creator');
            $table->index('member_id', 'idx_member');
            $table->index('last_message_at', 'idx_last_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
