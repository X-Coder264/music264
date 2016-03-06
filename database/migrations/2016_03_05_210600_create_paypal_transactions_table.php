<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_transactions', function (Blueprint $table) {
            $table->string('transaction_id');
            $table->primary('transaction_id');
            $table->unsignedInteger('payer_user_id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('payee_user_id');
            $table->string('payer_first_name');
            $table->string('payer_last_name');
            $table->string('payer_email');
            $table->dateTime('transaction_time');
            $table->string('transaction_amount');
            $table->enum('transaction_currency', ['EUR', 'USD'])->default('EUR');
            $table->string('invoice_path');
            $table->foreign('payer_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('service_id')->on('service_user')->onDelete('cascade');
            $table->foreign('payee_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('paypal_transactions');
    }
}
