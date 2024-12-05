<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vslas', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('representative_name');
            $table->string('representative_id');
            $table->string('representative_phone')->nullable();
            $table->string('sector')->nullable();
            $table->string('cell')->nullable();
            $table->string('village')->nullable();
            $table->string('entrance_year')->nullable();
            $table->string('mou_sign_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vslas');
    }
};
