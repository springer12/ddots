<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkRimeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_time_reports', function (Blueprint $table) {
            $table->increments('id');

            $table->string('desc', 2000);
            $table->dateTime('when');
            $table->integer('minutes');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sponsors');
    }
}
