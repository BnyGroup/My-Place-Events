<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColOrderPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_payment', function (Blueprint $table) {
            $table->string('stripe_id')->after('id')->nullable();
            $table->string('failure_code')->after('payment_currency')->nullable();
            $table->string('failure_message')->after('payment_currency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_payment', function (Blueprint $table) {
            $table->dropColumn('stripe_id');
            $table->dropColumn('failure_code');
            $table->dropColumn('failure_message');
        });
    }
}
