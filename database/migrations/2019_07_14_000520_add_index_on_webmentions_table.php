<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexOnWebmentionsTable extends Migration
{
    public function up()
    {
        Schema::table('webmentions', function (Blueprint $blueprint) {
            $blueprint->index('post_id');
        });
    }
}
