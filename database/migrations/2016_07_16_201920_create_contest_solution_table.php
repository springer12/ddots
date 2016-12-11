<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestSolutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_solution', function (Blueprint $table) {
            $table->integer('contest_id')->unsigned();
            $table->unsignedBigInteger('solution_id');

            $table->foreign('contest_id')
                ->references('id')->on('contests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('solution_id')
                ->references('id')->on('solutions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['contest_id', 'solution_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contest_solution');
    }
}
