<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_search_configs', function (Blueprint $table) {
            $table->integer('number_of_urls_indexed')->default(0);
        });
    }
};
