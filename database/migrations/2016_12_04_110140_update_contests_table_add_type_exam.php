<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContestsTableAddTypeExam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            \DB::statement("ALTER TABLE contests DROP COLUMN type;");
            $table->enum('type', [\App\Contest::TYPE_TOURNAMENT, \App\Contest::TYPE_EXAM]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contests', function (Blueprint $table) {
            \DB::statement("ALTER TABLE contests DROP COLUMN type;");
            $table->enum('type', [\App\Contest::TYPE_TOURNAMENT]);
        });
    }
}
