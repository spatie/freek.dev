<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectsTable extends Migration
{
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id');

            $table->string('old_url', 1024);
            $table->string('new_url', 512);

            $table->timestamps();
        });
    }
}
