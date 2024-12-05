<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_feeding_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_feeding_id')->constrained('school_feedings');
            $table->string('academic_year');
            $table->string('trimester');
            $table->string('amount')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('school_feeding_payments');
    }
};
