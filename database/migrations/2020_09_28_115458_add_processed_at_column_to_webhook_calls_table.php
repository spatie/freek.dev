<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcessedAtColumnToWebhookCallsTable extends Migration
{
    public function up()
    {
        Schema::table('webhook_calls', function (Blueprint $table) {
            $table->timestamp('processed_at')->nullable();
        });
    }
}
