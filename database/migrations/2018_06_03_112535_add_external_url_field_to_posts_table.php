<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalUrlFieldToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function(Blueprint $table) {
            $table->string('external_url')->nullable();
        });
    }
}
