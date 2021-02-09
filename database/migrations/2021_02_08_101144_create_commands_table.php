<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->integer('price');
            $table->date('dateToGive');
            $table->string('client_name');
            $table->text('comment');
            $table->boolean('isPaid');
            $table->unsignedBigInteger('clothe_id')->nullable();
            $table->foreign('clothe_id')->references('id')->on('clothes');
            $table->string('clothe_title');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('commands');
    }
}
