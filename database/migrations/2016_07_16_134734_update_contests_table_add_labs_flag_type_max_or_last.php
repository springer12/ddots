<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContestsTableAddLabsFlagTypeMaxOrLast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->boolean('labs')->default(false);
            $table->enum('type', [
                'tournament',
            ])->default('tournament');
            $table->boolean('show_max')->default(true);
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
            $table->dropColumn('labs');
            $table->dropColumn('type');
        });
    }
}
