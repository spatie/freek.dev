<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('response_cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value')->charset('binary');
            $table->bigInteger('expiration')->index();
        });
    }
};
