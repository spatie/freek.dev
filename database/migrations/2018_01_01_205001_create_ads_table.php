<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_on_url')->default('');
            $table->text('text');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->timestamps();
        });
    }
};
