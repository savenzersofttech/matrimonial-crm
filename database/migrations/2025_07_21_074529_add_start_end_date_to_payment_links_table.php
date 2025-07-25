<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartEndDateToPaymentLinksTable extends Migration
{
    public function up()
    {
        Schema::table('payment_links', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('sent_at');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    public function down()
    {
        Schema::table('payment_links', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
}
