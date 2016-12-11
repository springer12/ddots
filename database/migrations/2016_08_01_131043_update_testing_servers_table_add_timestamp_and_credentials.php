<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestingServersTableAddTimestampAndCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('testing_servers', function (Blueprint $table) {
            $table->timestamp('token_created_at');
            $table->string('login');
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testing_servers', function (Blueprint $table) {
            $table->dropColumn('token_created_at');
            $table->dropColumn('login');
            $table->dropColumn('password');
        });
    }
}
