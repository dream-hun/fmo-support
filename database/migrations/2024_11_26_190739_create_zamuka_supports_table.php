<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zamuka_supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zamuka_id')->constrained('zamukas');
            $table->date('done_at')->nullable();
            $table->string('support_given')->nullable();
            $table->string('value_of_support')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zamuka_supports');
    }
};
