<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->string('description', 3000);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->boolean('is_active');
            $table->boolean('is_standings_active');
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
            $table->dropColumn('description');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('is_active');
            $table->dropColumn('is_standings_active');
        });
    }
}
