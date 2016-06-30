<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activations', function (Blueprint $table) {
            $table->integer('user_id')->unique();
            $table->string('token');
            $table->timestamp('created_at');
        });
        Schema::table('users', function (Blueprint $table) {
           $table->dropColumn('email_verification_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_activations');
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_verification_code', 13)->nullable()->after('fb_link');
        });
    }
}
