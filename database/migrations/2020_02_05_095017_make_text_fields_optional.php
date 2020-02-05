<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTextFieldsOptional extends Migration
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
}
