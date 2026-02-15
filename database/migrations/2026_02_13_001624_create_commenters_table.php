<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commenters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('github_id')->unique();
            $table->string('username');
            $table->string('name');
            $table->string('avatar_url');
            $table->string('token')->unique();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commenters');
    }
};
