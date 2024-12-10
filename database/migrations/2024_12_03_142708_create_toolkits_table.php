<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toolkits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('tvet_attended')->nullable();
            $table->string('option')->nullable();
            $table->string('level')->nullable();
            $table->string('training_intake')->nullable();
            $table->string('reception_date')->nullable();
            $table->string('toolkit_received')->nullable();
            $table->decimal('toolkit_cost')->nullable();
            $table->decimal('subsidized_percent')->nullable();
            $table->string('sector')->nullable();
            $table->decimal('total')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toolkits');
    }
};
