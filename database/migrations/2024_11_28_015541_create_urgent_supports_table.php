<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('urgent_supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urgent_id')->constrained('urgents');
            $table->string('support_received');
            $table->longText('notes')->nullable();
            $table->date('done_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urgent_supports');
    }
};
