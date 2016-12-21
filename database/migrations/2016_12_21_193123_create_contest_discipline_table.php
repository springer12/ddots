<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestDisciplineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_discipline', function (Blueprint $table) {
            $table->unsignedInteger('contest_id');
            $table->unsignedInteger('discipline_id');

            $table->foreign('contest_id')
                ->references('id')
                ->on('contests')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('discipline_id')
                ->references('id')
                ->on('disciplines')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['contest_id', 'discipline_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contest_discipline');
    }
}
