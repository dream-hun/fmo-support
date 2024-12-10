<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_top_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vsla_id')->constrained('vslas');
            $table->integer('amount');
            $table->date('done_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_top_ups');
    }
};
