<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeDisplayOnUrlNullable extends Migration
{
    public function up()
    {
        Schema::table('ads', function(Blueprint $table) {
            $table->string('display_on_url')->nullable()->change();
        });
    }
}
