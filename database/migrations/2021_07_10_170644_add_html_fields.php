<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->longText('html')->nullable();
        });

        Schema::table('ads', function (Blueprint $table) {
            $table->longText('html')->nullable();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->longText('html')->nullable();
        });
    }
};
