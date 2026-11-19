<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('authenticatable');
            $table->string('guard')->nullable();
            $table->string('identifier')->nullable();
            $table->boolean('successful');
            $table->boolean('blocked')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedTinyInteger('risk_score')->nullable();
            $table->string('risk_level')->nullable();
            $table->json('reasons')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->index(['ip_address', 'created_at']);
        });
    }
};
