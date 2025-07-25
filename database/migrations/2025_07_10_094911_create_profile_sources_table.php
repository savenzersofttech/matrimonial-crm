<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Shaadi.com, MB, etc.
            $table->timestamps();
        });

         // Insert default values
        DB::table('profile_sources')->insert([
    ['name' => 'Shaadi.com', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Bharat Matrimonial', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Jeevansathi.com', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'News', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Others', 'created_at' => now(), 'updated_at' => now()],
]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_sources');
    }
};
