<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('site_search_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('crawl_url');
            $table->string('index_base_name');
            $table->boolean('enabled')->default(true);
            $table->string('driver_class')->nullable();
            $table->string('profile_class')->nullable();
            $table->json('extra')->nullable();
            $table->string('index_name')->nullable();
            $table->string('pending_index_name')->nullable();
            $table->dateTime('crawling_started_at')->nullable();
            $table->dateTime('crawling_ended_at')->nullable();
            $table->timestamps();
        });
    }
};
