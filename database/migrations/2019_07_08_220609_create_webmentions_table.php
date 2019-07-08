<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebmentionsTable extends Migration
{
    public function up()
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
            $table->string('text');
            $table->timestamps();
        });
    }
}
