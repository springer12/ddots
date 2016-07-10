<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemVolumeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem_volume', function (Blueprint $table) {

            $table->integer('problem_id')->unsigned();
            $table->integer('volume_id')->unsigned();
            $table->foreign('problem_id')
                ->references('id')
                ->on('problems')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('volume_id')
                ->references('id')
                ->on('volumes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['problem_id', 'volume_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('problem_volume');
    }
}
