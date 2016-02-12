<?php

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
            $table->string('name');
            $table->string('email')->unique()
                                   ->nullable();
            $table->enum('notify', ['y', 'n'])->default('y');
            $table->string('password', 60);
            $table->date('date_of_birth');
            $table->string('sex', 1);
            $table->string('description', 1800);
            $table->string('location');
            $table->string('image_name');
            $table->string('image_path');
            $table->string('thumbnail_path');
            $table->string('provider', 32);
            $table->string('provider_id');
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
        Schema::drop('users');
    }
}
