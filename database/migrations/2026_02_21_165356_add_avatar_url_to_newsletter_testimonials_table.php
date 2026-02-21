<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsletter_testimonials', function (Blueprint $table) {
            $table->string('avatar_url')->nullable()->after('author_url');
        });
    }
};
