<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplineProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discipline_problem', function (Blueprint $table) {
            $table->unsignedInteger('discipline_id');
            $table->unsignedInteger('problem_id');

            $table->foreign('discipline_id')
                ->references('id')
                ->on('disciplines')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('problem_id')
                ->references('id')
                ->on('problems')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['discipline_id', 'problem_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('discipline_problem');
    }
}
