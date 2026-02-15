<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commenter_id')->constrained()->cascadeOnDelete();
            $table->morphs('reactable');
            $table->string('emoji')->collation('utf8mb4_bin');
            $table->timestamps();

            $table->unique(['commenter_id', 'reactable_type', 'reactable_id', 'emoji']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
