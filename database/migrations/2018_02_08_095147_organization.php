<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Organization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations',function(Blueprint $table){
            $table->increments('id');
            $table->string('profile_pic')->nullable();
            $table->string('organizer_name');
            $table->longtext('about_organizer')->nullable();
            $table->tinyInteger('display_dis')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_page')->nullable();
            $table->string('twitter')->nullable();
            $table->string('url_slug')->nullable();
            $table->tinyInteger('ban')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('user_id')->unsigned();
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
        //
    }
}
