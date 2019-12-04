<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropNewslettersTable extends Migration
{
    public function up()
    {
        Schema::drop('newsletters');
    }
}
