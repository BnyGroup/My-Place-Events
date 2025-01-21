<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('ot_user_id');
            $table->bigInteger('ot_event_id');
            $table->string('ot_order_id');
            $table->string('ot_ticket_id');
            $table->string('ot_qr_code');
            $table->string('ot_qr_image');
            $table->string('ot_f_name');
            $table->string('ot_l_name')->nullable();
            $table->string('ot_email');
            $table->tinyInteger('ot_status')->default(0);
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
        Schema::dropIfExists('order_tickets');
    }
}
