<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('supervisor_id');
            $table->string('payroll_designation')->nullable();
            $table->string('payroll_functional_unit')->nullable();
            $table->string('band')->nullable();
            $table->date('payroll_joining_date')->nullable();
            $table->double('offered_salary')->nullable();
            $table->date('last_salary_revision')->nullable();
            $table->double('latest_salary')->nullable();
            $table->integer('salary_revision_count')->nullable();
            $table->integer('level_increase_count')->nullable();
            $table->date('resign_date')->nullable();
            $table->date('last_working_date')->nullable();
            $table->date('payroll_relieving_date')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
