<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('national_id_number');
            $table->string('district');
            $table->string('sector');
            $table->string('cell');
            $table->string('village');
            $table->string('telephone');
            $table->string('email');
            $table->string('university_attended');
            $table->string('faculty');
            $table->string('program_duration');
            $table->string('year_of_entrance');
            $table->string('intake')->nullable();
            $table->string('school_contact')->nullable();
            $table->string('status')->nullable()->default('Inprogress');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
