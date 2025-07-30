<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('lead_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('lead_id')->nullable();
        $table->unsignedBigInteger('profile_id')->nullable();
        $table->string('action'); // created, updated, deleted, assigned, etc.
        $table->unsignedBigInteger('user_id')->nullable(); // who did it
        $table->json('changes')->nullable(); // optional, for storing diff
        $table->timestamps();

        $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_logs');
    }
};
