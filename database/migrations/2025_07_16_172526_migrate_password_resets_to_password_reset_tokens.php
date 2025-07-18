<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('password_resets')) {
            DB::statement('INSERT INTO password_reset_tokens (email, token, created_at) SELECT email, token, created_at FROM password_resets');
        }
    }
};
