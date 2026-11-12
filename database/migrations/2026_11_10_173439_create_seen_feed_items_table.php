<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seen_feed_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitored_feed_id')->constrained()->cascadeOnDelete();
            $table->text('identifier');
            $table->char('identifier_hash', 64);
            $table->text('url');
            $table->char('url_hash', 64);
            $table->text('title')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('seen_at');
            $table->unique(['monitored_feed_id', 'identifier_hash']);
            $table->index(['monitored_feed_id', 'url_hash']);
            $table->timestamps();
        });
    }
};
