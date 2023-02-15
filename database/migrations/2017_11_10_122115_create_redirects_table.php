<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id');

            $table->string('old_url', 1024);
            $table->string('new_url', 512);

            $table->timestamps();
        });
    }
};
