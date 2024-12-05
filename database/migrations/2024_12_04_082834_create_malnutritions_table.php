<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('malnutritions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('age_or_months')->nullable();
            $table->string('associated_health_center');
            $table->string('sector')->nullable();
            $table->string('cell')->nullable();
            $table->string('village')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('home_phone_number')->nullable();
            $table->string('entry_muac');
            $table->string('current_muac');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('malnutritions');
    }
};
