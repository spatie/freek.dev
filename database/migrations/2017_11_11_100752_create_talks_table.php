<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('location');
            $table->timestamp('presented_at');
            $table->string('video_link')->nullable();
            $table->string('slides_link')->nullable();
            $table->string('joindin_link')->nullable();
            $table->timestamps();
        });
    }
};
