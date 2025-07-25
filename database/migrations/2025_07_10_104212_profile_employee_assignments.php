<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_employee_assignments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('profile_id');   // FK to profiles.id
            $table->unsignedBigInteger('employee_id');     // FK to users.id (staff)
            $table->unsignedBigInteger('assigned_by');  // FK to users.id (admin)

            $table->timestamp('assigned_at')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_employee_assignments');
    }
};
