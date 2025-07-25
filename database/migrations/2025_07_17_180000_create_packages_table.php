<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Exclusive 1 month
            $table->string('slug')->unique(); // e.g. exclusive-1-month
            $table->integer('duration_days'); // e.g. 30, 90, etc.
            $table->enum('type', ['exclusive', 'elite', 'open'])->default('exclusive');
            $table->integer('price')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
