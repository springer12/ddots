<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolutionsReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', [
                'CE',
                'FF',
                'NC',
                'CC',
                'CT',
                'UE',
                'OK',
                'WA',
                'PE',
                'RE',
                'TL',
                'ML',
            ]);

            $table->float('execution_time');
            $table->float('memory_peak');

            $table->unsignedBigInteger('solution_id');
            $table->foreign('solution_id')
                ->references('id')->on('solutions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::drop('solutions_reports');
    }
}
