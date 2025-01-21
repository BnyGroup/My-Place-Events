<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderTCommToEventBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_booking', function (Blueprint $table) {
            $table->longText('order_t_commission')->after('order_t_fees')->nullable();
            $table->decimal('order_commission',8, 2)->after('order_amount');
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
            $table->dropColumn('order_t_commission');
            $table->dropColumn('order_commission');
        });
    }
}
