<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname',20);
            $table->string('lastname',20);
            $table->string('username',15);
            $table->tinyInteger('admin_type')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('user_type')->default(0);
            $table->string('current_login')->nullable();
            $table->string('last_login')->nullable();
            $table->string('profile_pic')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->date('brith_date')->nullable();
            $table->string('email');
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
