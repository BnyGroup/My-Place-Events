<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FrontUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname',20);
            $table->string('lastname',20);
            $table->tinyInteger('status')->default(0);
            $table->string('profile_pic')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('cellphone')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('reason')->nullable();
            $table->string('other_reason')->nullable();
            $table->rememberToken();
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
        
    }
}
