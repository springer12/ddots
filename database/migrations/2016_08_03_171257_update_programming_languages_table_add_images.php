<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProgrammingLanguagesTableAddImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programming_languages', function (Blueprint $table) {
            $table->string('compiler_image')->nullable();
            $table->string('executor_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solutions', function (Blueprint $table) {
            $table->dropColumn('compiler_image');
            $table->dropColumn('executor_image');
        });
    }
}
