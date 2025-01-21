<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_booking', function (Blueprint $table) {
            $table->bigInteger('gust_id')->nullable()->after('user_id');
        });

        Schema::table('order_tickets', function (Blueprint $table) {
            $table->bigInteger('gust_id')->nullable()->after('ot_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_booking', function (Blueprint $table) {
            $table->dropColumn('gust_id');
        });
        
        Schema::table('order_tickets', function (Blueprint $table) {
            $table->dropColumn('gust_id');
        });
    }
}
