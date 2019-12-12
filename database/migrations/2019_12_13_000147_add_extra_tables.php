<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailcoach_segments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('all_positive_tags_required')->default(false);
            $table->boolean('all_negative_tags_required')->default(false);
            $table->unsignedBigInteger('email_list_id');
            $table->timestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('mailcoach_email_lists')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_positive_segment_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('segment_id');
            $table->unsignedBigInteger('tag_id');

            $table
                ->foreign('segment_id')
                ->references('id')->on('mailcoach_segments')
                ->onDelete('cascade');

            $table
                ->foreign('tag_id')
                ->references('id')->on('mailcoach_tags')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_negative_segment_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('segment_id');
            $table->unsignedBigInteger('tag_id');

            $table
                ->foreign('segment_id')
                ->references('id')->on('mailcoach_segments')
                ->onDelete('cascade');

            $table
                ->foreign('tag_id')
                ->references('id')->on('mailcoach_tags')
                ->onDelete('cascade');
        });

        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('segment_id')->nullable();

            $table
                ->foreign('segment_id')
                ->references('id')->on('mailcoach_segments')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
