<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('mailcoach_uuid')->unique();
            $table->string('name');
            $table->integer('edition_number');
            $table->string('slug')->unique();
            $table->longText('web_view_html');
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }
};
