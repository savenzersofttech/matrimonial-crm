<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');

            // ENUM status with all stages in uppercase
            $table->enum('status', [
                'New',
                'Contacted',
                'Follow Up',
                'Qualified',
                'Not Interested',
                'Lost',
                'Converted'
            ])->default('NEW');

            $table->timestamp('follow_up')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles');
                // No cascade on delete to preserve profile
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
