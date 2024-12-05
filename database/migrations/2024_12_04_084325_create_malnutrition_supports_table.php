<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('malnutrition_supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('malnutrition_id')->constrained('malnutritions');
            $table->date('package_reception_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('malnutrition_supports');
    }
};
