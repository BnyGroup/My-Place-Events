<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('payment_user_id');
            $table->string('payment_order_id');
            $table->bigInteger('payment_event_id');
            $table->decimal('payment_amount', 8, 2);
            $table->string('payment_currency');
            $table->string('payment_status')->default(0);
            $table->string('payment_gateway')->nullable();
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
        Schema::dropIfExists('order_payment');
    }
}
