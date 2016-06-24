<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTableForProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('email');
            $table->string('place_of_study', 255)->nullable()->after('age');
            $table->string('profession', 255)->nullable()->after('place_of_study');
            $table->timestamp('last_login')->after('updated_at');
            $table->bigInteger('primary_language')->nullable()->after('profession');
            $table->string('vk_link', 255)->nullable()->after('primary_language');
            $table->string('fb_link', 255)->nullable()->after('vk_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
