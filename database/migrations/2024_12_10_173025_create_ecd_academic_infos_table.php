<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ecd_academic_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ecd_id')->constrained('ecds');
            $table->string('academic_year')->nullable();
            $table->string('grade')->nullable();
            $table->string('status')->nullable();
            $table->longText('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecd_academic_infos');
    }
};
