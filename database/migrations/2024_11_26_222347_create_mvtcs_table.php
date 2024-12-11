<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mvtcs', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no')->nullable();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('student_id')->nullable();
            $table->string('student_contact')->nullable();
            $table->string('trade')->nullable();
            $table->string('resident_district')->nullable();
            $table->string('sector')->nullable();
            $table->string('cell')->nullable();
            $table->string('village')->nullable();
            $table->string('education_level')->nullable();
            $table->string('scholar_type')->nullable();
            $table->string('intake')->nullable();
            $table->string('graduation_date')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mvtcs');
    }
};
