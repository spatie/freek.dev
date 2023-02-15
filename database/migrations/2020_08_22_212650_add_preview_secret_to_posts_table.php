<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('preview_secret');
        });

        Post::each(function (Post $post) {
            $post->update(['preview_secret' => \Illuminate\Support\Str::random(10)]);
        });
    }
};
