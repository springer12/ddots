<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolutionMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solution_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('solution_id')->unsigned();
            $table->unsignedInteger('user_id');
            $table->string('text');
            $table->timestamps();


            $table->foreign('solution_id')
                ->references('id')
                ->on('solutions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solution_messages');
    }
}
