<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventColLongigutLatitude extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('event_latitude')->nullable()->after('event_location');
            $table->string('event_longitude')->nullable()->after('event_latitude');
            $table->string('event_city')->nullable()->after('event_latitude');
            $table->string('event_state')->nullable()->after('event_city');
            $table->string('event_country')->nullable()->after('event_state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('event_latitude');
            $table->dropColumn('event_longitude');
            $table->dropColumn('event_city');
            $table->dropColumn('event_state');
            $table->dropColumn('event_country');
        });
    }
}
