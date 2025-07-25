<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('mother_tongue_other')->nullable()->after('mother_tongue');
            $table->string('health_status_other')->nullable()->after('health_status');
            $table->string('religion_other')->nullable()->after('religion');
            $table->string('diet_other')->nullable()->after('diet');
            $table->string('body_type_other')->nullable()->after('body_type');
            $table->string('profile_for_other')->nullable()->after('profile_for');
            $table->string('caste_other')->nullable()->after('caste');

            $table->string('highest_qualification_other')->nullable()->after('highest_qualification');
            $table->string('education_field_other')->nullable()->after('education_field');

            $table->string('employer_name_other')->nullable()->after('employer_name');
            $table->string('profession_other')->nullable()->after('profession');

            $table->string('father_occupation_other')->nullable()->after('father_occupation');
            $table->string('mother_occupation_other')->nullable()->after('mother_occupation');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'mother_tongue_other',
                'health_status_other',
                'religion_other',
                'diet_other',
                'body_type_other',
                'profile_for_other',
                'caste_other',
                'highest_qualification_other',
                'education_field_other',
                'employer_name_other',
                'profession_other',
                'father_occupation_other',
                'mother_occupation_other',
            ]);
        });
    }
};
