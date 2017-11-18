<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOriginalContentField extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('original_content')->default(false);
        });
    }
}
