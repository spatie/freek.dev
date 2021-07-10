<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->longText('text')->change()->nullable();
        });

        Schema::table('links', function (Blueprint $table) {
            $table->longText('text')->change()->nullable();
        });
    }
};
