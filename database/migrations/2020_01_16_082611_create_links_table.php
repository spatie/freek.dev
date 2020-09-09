<?php

use App\Models\Link;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('approved')->default(false);
            $table->unsignedInteger('user_id');

            $table->string('title');
            $table->string('slug');
            $table->longText('text');
            $table->text('url');

            $table->string('status')->default(Link::STATUS_SUBMITTED);
            $table->timestamp('publish_date')->nullable()->default(null);

            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }
}
