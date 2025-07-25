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
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('Pending'); // Interested, Follow-up Needed, No Response, Not Interested
            $table->text('comment')->nullable();
            $table->datetime('follow_up_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('welcome_calls');
    }
}