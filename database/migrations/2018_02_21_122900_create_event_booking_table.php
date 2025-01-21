<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('event_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('event_id');
            $table->bigInteger('user_id');
            $table->string('order_id');
            $table->integer('order_tickets');
            $table->decimal('order_amount', 8, 2);
                        
            $table->longText('order_t_id')->nullable();
            $table->longText('order_t_title')->nullable();
            $table->longText('order_t_qty')->nullable();
            $table->longText('order_t_price')->nullable();
            $table->longText('order_t_fees')->nullable();

            $table->string('client_token')->nullable();
            $table->tinyInteger('order_status')->default(0);

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
        Schema::dropIfExists('event_booking'); 
    }
}
