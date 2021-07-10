<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->string('send_batch_id')->nullable();
        });
    }
};
