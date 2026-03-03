<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_search_documents', function (Blueprint $table) {
            $table->id();
            $table->string('index_name')->index();
            $table->string('document_id');
            $table->text('url');
            $table->text('anchor')->nullable();
            $table->text('page_title')->nullable();
            $table->text('h1')->nullable();
            $table->longText('entry')->nullable();
            $table->text('description')->nullable();
            $table->integer('date_modified_timestamp')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();

            $table->unique(['index_name', 'document_id']);
        });
    }
};
