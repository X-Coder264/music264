<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->foreign('transaction_id')->references('transaction_id')->on('paypal_transactions')->onDelete('cascade');
            $table->integer('value');
            $table->string('comment');
            $table->dateTime('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_ratings');
    }
}
