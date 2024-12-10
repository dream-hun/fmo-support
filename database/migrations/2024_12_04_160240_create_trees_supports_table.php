<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trees_supports', function (Blueprint $table) {
            $table->id();
            $table->integer('avocadoes')->nullable();
            $table->integer('mangoes')->nullable();
            $table->integer('oranges')->nullable();
            $table->integer('papaya')->nullable();
            $table->foreignId('tree_id')->constrained('trees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trees_supports');
    }
};
