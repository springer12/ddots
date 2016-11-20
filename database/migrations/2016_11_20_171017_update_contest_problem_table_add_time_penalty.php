<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContestProblemTableAddTimePenalty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contest_problem', function (Blueprint $table) {
            $table->integer('time_penalty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contest_problem', function (Blueprint $table) {
            $table->dropColumn('time_penalty');
        });
    }
}
