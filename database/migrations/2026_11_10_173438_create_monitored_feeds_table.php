<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitored_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('url');
            $table->char('url_hash', 64)->unique();
            $table->string('type');
            $table->boolean('enabled')->default(true);
            $table->timestamp('baseline_before')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }
};
