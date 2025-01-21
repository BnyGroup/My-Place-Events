<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColInEventBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_booking', function (Blueprint $table) {
            $table->unsignedInteger('manual_attend_vendor')->after('client_token')->default(0);
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
           $table->dropColumn('manual_attend_vendor');
        });
    }
}
