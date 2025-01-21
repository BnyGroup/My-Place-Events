<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table) {

            $table->increments('id');
            $table->bigInteger('event_unique_id');
            $table->integer('event_category')->unsigned();
            $table->string('event_name');
            $table->string('event_slug');
            $table->longText('event_description');
            $table->string('event_location')->nullable();
            $table->tinyInteger('map_display')->default(0);
            $table->text('event_address')->nullable();
            $table->dateTime('event_start_datetime');
            $table->dateTime('event_end_datetime');
            $table->string('event_image');
            $table->string('event_url')->nullable();
            $table->string('event_qrcode')->nullable();
            $table->string('event_qrcode_image')->nullable();
            $table->string('event_create_by')->nullable();
            $table->string('event_org_name')->nullable();            
            $table->string('event_facebook')->nullable();
            $table->string('event_instagaram')->nullable();
            $table->string('evetn_twitter')->nullable();
            $table->tinyInteger('event_remaining')->default(0);
            $table->tinyInteger('event_status');
            $table->tinyInteger('ban')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
