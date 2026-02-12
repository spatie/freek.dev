<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('reactions');
        Schema::dropIfExists('comment_notification_subscriptions');
        Schema::dropIfExists('comments');
    }
};
