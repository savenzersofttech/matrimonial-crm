<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWelcomeCallsTable extends Migration
{
    public function up(): void
    {
        Schema::create('welcome_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('call_time')->nullable();
            $table->enum('status', ['Pending', 'Completed', 'Missed', 'Rescheduled'])->default('Pending');
            $table->enum('outcome', ['Successful', 'No Answer', 'Follow-up Needed', 'Client Unreachable'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('welcome_calls');
    }
}