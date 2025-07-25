<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_source_id')->constrained('profile_sources')->onDelete('restrict');
            $table->string('profile_source_comment')->nullable();
            $table->string('profile_id')->unique()->notNull(); // Required and unique
            $table->string('email')->nullable()->unique();
            $table->string('alternative_email')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->string('alternative_phone_number')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('profile_for')->nullable();
            $table->string('name')->notNull(); // Required
            $table->enum('gender', ['Male', 'Female'])->notNull(); // Required
            $table->date('date_of_birth')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('height')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->integer('weight')->nullable();
            $table->string('body_type')->nullable();
            $table->string('complexion')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('health_status')->nullable();
            $table->string('native_place')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('citizenship')->nullable();
            $table->json('grow_up_in')->nullable();
            $table->json('government_id')->nullable();
            $table->json('photo')->nullable();
            $table->string('password')->nullable();
            $table->text('bio')->nullable();
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('sub_caste')->nullable();
            $table->string('gotra')->nullable();
            $table->time('birth_time')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('manglik_status')->nullable();
            $table->json('highest_qualification')->nullable(); // Changed to json for array
            $table->json('education_field')->nullable(); // Changed to json for array
            $table->string('institute_name')->nullable();
            $table->string('work_location')->nullable();
            $table->string('employer_name')->nullable();
            $table->json('profession')->nullable(); // Changed to json for array
            $table->string('business_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('annual_income')->nullable();
            $table->string('diet')->nullable();
            $table->string('drinking_status')->nullable();
            $table->string('smoking_status')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->unsignedTinyInteger('brother_count')->default(0);
            $table->unsignedTinyInteger('married_brother_count')->default(0);
            $table->unsignedTinyInteger('sister_count')->default(0);
            $table->unsignedTinyInteger('married_sister_count')->default(0);
            $table->string('family_type')->nullable();
            $table->string('family_affluence')->nullable();
            $table->string('family_values')->nullable();
            $table->text('family_bio')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}