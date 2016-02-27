<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('artist_user_id')->unsigned()->index();
            $table->foreign('artist_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('venue_user_id')->unsigned()->index();
            $table->foreign('venue_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('description');
            $table->dateTime('time');
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
        Schema::drop('events');
    }
}
