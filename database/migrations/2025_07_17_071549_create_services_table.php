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
        Schema::create('services', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('profile_id');  
        $table->string('plan');                        
        $table->date('start_date');
        $table->date('end_date');
        $table->enum('status', ['Active', 'Expiring Soon', 'Expired'])->default('Active');
        $table->string('remarks')->nullable(); 
        $table->integer('price')->nullable();
        $table->unsignedBigInteger('added_by')->nullable();  
        $table->unsignedBigInteger('updated_by')->nullable(); 

        $table->timestamps();

        // Foreign keys
        $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
        $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
