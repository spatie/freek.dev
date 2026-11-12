<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('shared_tweet_url')->nullable();
            $table->string('shared_tweet_author')->nullable();
            $table->text('shared_tweet_text')->nullable();
        });
    }
};
