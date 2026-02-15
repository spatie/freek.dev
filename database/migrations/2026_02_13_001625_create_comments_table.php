<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commenter_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->text('body');
            $table->text('body_html');
            $table->timestamps();

            $table->index(['post_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
