<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('text');
            $table->string('wp_id')->nullable();
            $table->string('wp_post_name')->nullable();
            $table->datetime('publish_date');
            $table->boolean('published')->default(false);
            $table->boolean('tweet_sent')->default(false);
            $table->boolean('posted_on_medium')->default(false);
            $table->string('author')->default('Freek Van der Herten');
            $table->timestamps();
        });
    }
}
