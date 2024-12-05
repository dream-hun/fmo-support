<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('musa_supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musa_id')->constrained('musas');
            $table->integer('support_given');
            $table->date('date_of_support')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('musa_supports');
    }
};
