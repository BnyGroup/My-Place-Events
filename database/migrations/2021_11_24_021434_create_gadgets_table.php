<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGadgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gadgets', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('item_unique_id');
            $table->integer('item_category')->unsigned();
            $table->string('item_name');
            $table->string('item_slug');
            $table->longText('item_description');
            $table->string('item_location')->nullable();
            $table->tinyInteger('map_display')->default(0);
            $table->text('item_address')->nullable();
            $table->dateTime('item_start_datetime');
            $table->dateTime('item_end_datetime');
            $table->string('item1_image');
            $table->string('item2_image');
            $table->string('item3_image');
            $table->string('item_url')->nullable();
            $table->string('item_qrcode')->nullable();
            $table->string('item_qrcode_image')->nullable();
            $table->string('item_create_by')->nullable();
            $table->string('item_org_name')->nullable();            
            $table->string('item_facebook')->nullable();
            $table->string('item_instagaram')->nullable();
            $table->string('item_twitter')->nullable();
            $table->tinyInteger('item_remaining')->default(0);
            $table->tinyInteger('item_status');
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
        Schema::dropIfExists('gadgets');
    }
}
