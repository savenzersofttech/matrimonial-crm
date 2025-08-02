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
            $table->unsignedInteger('price');
            $table->char('currency', 3)->default('INR');
            $table->integer('discount')->default(0);            // 0, 5, 10, 20, 30
            $table->decimal('final_amount', 10, 2)->nullable(); // amount after discount
            $table->string('payment_link')->nullable();         // Razorpay link or other gateway
            $table->string('token')->unique()->nullable();      // Used for unique payment link or tracking
            $table->enum('gateway', ['razorpay', 'paypal'])->default('razorpay'); // Payment gateway used
            $table->string('transaction_id')->nullable(); // ID returned by the payment gateway
            $table->json('gateway_response')->nullable(); // Raw JSON response from Razorpay/PayPal
            $table->enum('status', ['Pending', 'Paid', 'Failed'])->default('Pending')->index();
            $table->timestamp('sent_at')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
