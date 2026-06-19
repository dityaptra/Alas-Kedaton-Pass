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
        // Index untuk filter status order yang sering dipakai di admin
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index('visit_date');
        });

        // Index untuk filter artikel published
        Schema::table('articles', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });

        // Index untuk pencarian artikel berdasarkan judul
        Schema::table('articles', function (Blueprint $table) {
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['visit_date']);
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['title']);
        });
    }
};
