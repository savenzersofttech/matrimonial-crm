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
        Schema::create('payment_link_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_link_id');
            $table->string('action');                          // create, update, delete
            $table->json('changes')->nullable();               // what was changed
            $table->unsignedBigInteger('user_id')->nullable(); // who did it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_link_logs');
    }
};
