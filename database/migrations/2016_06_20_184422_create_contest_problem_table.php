<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_problem', function (Blueprint $table) {
            $table->unsignedInteger('problem_id');
            $table->foreign('problem_id')
                ->references('id')->on('problems')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('contest_id');
            $table->foreign('contest_id')
                ->references('id')->on('contests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['problem_id', 'contest_id']);
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
        Schema::drop('contest_problem');
    }
}
