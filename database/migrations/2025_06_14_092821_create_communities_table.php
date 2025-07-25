<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('religion_id'); // Foreign key
            $table->string('name');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};