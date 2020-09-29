<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTimezoneFieldToMonitoredScheduledTasksTable extends Migration
{
    public function up()
    {
        Schema::table('monitored_scheduled_tasks', function (Blueprint $table) {
            $table->string('timezone');
        });

        DB::table('monitored_scheduled_tasks')
            ->update(['timezone' => config('app.timezone')]);
    }
}
