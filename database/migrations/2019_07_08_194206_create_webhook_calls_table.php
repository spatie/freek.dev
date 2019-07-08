<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebhookCallsTable extends Migration
{
    public function up()
    {
        Schema::create('webhook_calls', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->text('payload')->nullable();
            $table->text('exception')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_calls');
    }
}
