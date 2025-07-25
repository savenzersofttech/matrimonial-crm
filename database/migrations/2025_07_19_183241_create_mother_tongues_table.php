<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mother_tongues', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Hindi, Tamil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mother_tongues');
    }
};
