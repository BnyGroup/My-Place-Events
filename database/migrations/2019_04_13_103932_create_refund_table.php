<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('event_id');
            $table->string('order_id');
            $table->bigInteger('user_id');
            $table->unsignedInteger('event_ower_id')->default(0);
            $table->enum('refund_status',['Pending','Accept','Reject']);
            $table->longText('reject_note')->nullable();
            $table->dateTime('transation_date');
            $table->timestamps();
        });
         Schema::table('events', function (Blueprint $table) {            
            $table->integer('refund_policy')->after('event_remaining');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds');
        Schema::table('events', function (Blueprint $table) {            
            $table->dropColumn('refund_policy');
        });
    }
}
