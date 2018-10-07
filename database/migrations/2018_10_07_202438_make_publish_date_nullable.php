<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePublishDateNullable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->datetime('publish_date')->nullable()->change();
        });
    }
}
