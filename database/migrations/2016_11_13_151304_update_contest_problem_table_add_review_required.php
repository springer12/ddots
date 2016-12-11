<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContestProblemTableAddReviewRequired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contest_problem', function (Blueprint $table) {
            $table->boolean('review_required')->default(false);
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
            $table->dropColumn('review_required');
        });
    }
}
