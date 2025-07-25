<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerPreferencesTable extends Migration
{
    public function up()
    {
        Schema::create('partner_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles')->onDelete('cascade');
            $table->unsignedTinyInteger('min_age')->nullable();
            $table->unsignedTinyInteger('max_age')->nullable();
            $table->string('min_height')->nullable();
            $table->string('max_height')->nullable();
            $table->json('marital_status')->nullable(); // Changed to json
            $table->json('mother_tongue')->nullable(); // Changed to json
            $table->json('religion')->nullable(); // Changed to json
            $table->json('caste')->nullable(); // Changed to json
            $table->json('manglik_status')->nullable(); // Changed to json
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('citizenship')->nullable();
            $table->json('grow_up_in')->nullable(); // Already json, unchanged
            $table->json('highest_qualification')->nullable(); // Changed to json
            $table->json('education_field')->nullable(); // Changed to json
            $table->json('employer_name')->nullable(); // Changed to json
            $table->json('profession')->nullable(); // Changed to json
            $table->string('designation')->nullable();
            $table->string('annual_income')->nullable();
            $table->json('diet')->nullable(); // Changed to json
            $table->json('drinking_status')->nullable(); // Changed to json
            $table->json('smoking_status')->nullable(); // Changed to json
            $table->text('about')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partner_preferences');
    }
}