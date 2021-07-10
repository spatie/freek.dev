<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('submitted_by_user_id')->nullable();

            $table
                ->foreign('submitted_by_user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }
};
