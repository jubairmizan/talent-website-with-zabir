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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['creator', 'member', 'admin'])->default('member')->after('password');
            $table->enum('status', ['active', 'banned', 'pending'])->default('pending')->after('role');
            $table->string('avatar', 500)->nullable()->after('status');

            $table->index('role', 'idx_role');
            $table->index('status', 'idx_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_role');
            $table->dropIndex('idx_status');
            $table->dropColumn(['role', 'status', 'avatar']);
        });
    }
};
