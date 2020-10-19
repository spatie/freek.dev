<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUnusedPostsFields extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('wp_id');
            $table->dropColumn('posted_on_medium');
        });
    }
}
