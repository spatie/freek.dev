<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webmentions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('webmention_id');
            $table->integer('post_id');
            $table->string('type');
            $table->string('author_name');
            $table->string('author_url')->nullable();
            $table->string('author_photo_url')->nullable();
            $table->string('interaction_url');
            $table->text('text')->nullable();
            $table->timestamps();
        });
    }
};
