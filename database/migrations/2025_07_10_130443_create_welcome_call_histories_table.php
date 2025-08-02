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
        Schema::create('welcome_call_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('welcome_call_id')->constrained()->onDelete('cascade');
            $table->foreignId('profile_id');
            $table->foreignId('user_id')->nullable();
            $table->timestamp('call_time')->nullable();
            $table->enum('status', ['New','Pending', 'Completed', 'Missed', 'Rescheduled'])->default('New');
            $table->enum('outcome', ['Successful', 'No Answer', 'Follow-up Needed', 'Client Unreachable'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_call_histories');
    }
};
