<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestProgrammingLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_programming_language', function (Blueprint $table) {
            $table->integer('contest_id')->unsigned();
            $table->integer('programming_language_id')->unsigned();

            $table->foreign('contest_id')
                ->references('id')
                ->on('contests')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('programming_language_id')
                ->references('id')
                ->on('programming_languages')
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
        Schema::drop('contest_programming_language');
    }
}
