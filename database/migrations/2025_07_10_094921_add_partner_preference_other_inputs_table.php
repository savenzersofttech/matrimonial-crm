<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('partner_preferences', function (Blueprint $table) {
            $table->string('religion_other')->nullable()->after('religion');
            $table->string('cast_other')->nullable()->after('caste');
            $table->string('diet_other')->nullable()->after('diet');
            $table->string('highest_qualification_other')->nullable()->after('highest_qualification');
            $table->string('education_field_other')->nullable()->after('education_field');
            $table->string('working_with_other')->nullable()->after('employer_name');
            $table->string('profession_other')->nullable()->after('profession');
        });
    }

    public function down(): void
    {
        Schema::table('partner_preferences', function (Blueprint $table) {
            $table->dropColumn([
                'religion_other',
                'cast_other',
                'diet_other',
                'highest_qualification_other',
                'education_field_other',
                'working_with_other',
                'profession_other',
            ]);
        });
    }
};
