<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventLinkSlugToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
         Schema::table('events', function (Blueprint $table) {            
            $table->string('event_link_slug')->after('event_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('events', function (Blueprint $table) {            
            $table->dropColumn('event_link_slug'); 
        });
    }
}
