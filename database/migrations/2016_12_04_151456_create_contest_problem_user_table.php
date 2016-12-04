<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestProblemUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_problem_user', function (Blueprint $table) {
            $table->unsignedInteger('contest_id');
            $table->unsignedInteger('problem_id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('max_points');
            $table->boolean('review_required')->default(false);
            $table->integer('time_penalty');

            $table->unique(['contest_id', 'problem_id', 'user_id']);

            $table->foreign('contest_id')
                ->references('id')->on('contests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('problem_id')
                ->references('id')->on('problems')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contest_problem_user');
    }
}
