<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EvenysTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_id');
            $table->bigInteger('event_id')->unsigned();
            $table->string('ticket_title');
            $table->longText('ticket_description')->nullable();
            $table->tinyInteger('ticket_desc_status')->default(0);
            $table->integer('ticket_qty')->unsigned();
            $table->bigInteger('ticket_remaning_qty')->default(0);
            $table->tinyInteger('ticket_type')->default(0);
            $table->tinyInteger('ticket_status')->default(0);
            $table->tinyInteger('ticket_services_fee')->default(0);
            $table->decimal('ticket_price_buyer', 8, 2)->nullable();
            $table->decimal('ticket_price_actual', 8, 2)->nullable();
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
        Schema::dropIfExists('event_tickets');
    }
}
