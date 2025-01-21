<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name');
            $table->string('category_slug');
            $table->string('category_parent')->nullable();
            $table->longtext('category_description')->nullable();
            $table->string('category_image')->nullable();
            $table->tinyInteger('category_status')->default(0);
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
        Schema::dropIfExists('event_category');
    }
}
