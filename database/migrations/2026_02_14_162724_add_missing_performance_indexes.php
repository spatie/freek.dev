<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['published', 'publish_date']);
            $table->index('external_url');
        });

        Schema::table('taggables', function (Blueprint $table) {
            $table->index(['taggable_type', 'taggable_id']);
        });

        Schema::table('ads', function (Blueprint $table) {
            $table->index(['starts_at', 'ends_at']);
        });

        Schema::table('links', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['published', 'publish_date']);
            $table->dropIndex(['external_url']);
        });

        Schema::table('taggables', function (Blueprint $table) {
            $table->dropIndex(['taggable_type', 'taggable_id']);
        });

        Schema::table('ads', function (Blueprint $table) {
            $table->dropIndex(['starts_at', 'ends_at']);
        });

        Schema::table('links', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
