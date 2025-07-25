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
        Schema::create('payment_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('plan_id');
            $table->decimal('price', 10, 2);
            $table->integer('discount')->default(0); // 0, 5, 10, 20, 30
            $table->decimal('final_amount', 10, 2)->nullable(); // amount after discount
            $table->string('payment_link')->nullable(); // Razorpay link or other gateway
            $table->enum('status', ['pending', 'paid', 'expired'])->default('pending');
            $table->timestamps();

            // Foreign key to profiles table
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
                    $table->foreign('plan_id')->references('id')->on('packages');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_links');
    }
};
