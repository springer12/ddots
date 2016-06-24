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
            $table->date('date_of_birth')->nullable()->after('email');
            $table->string('place_of_study', 255)->nullable()->after('date_of_birth');
            $table->string('profession', 255)->nullable()->after('place_of_study');
            $table->timestamp('last_login')->after('updated_at');
            $table->bigInteger('programming_language')->nullable()->after('profession');
            $table->string('vk_link', 255)->nullable()->after('programming_language');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('place_of_study');
            $table->dropColumn('profession');
            $table->dropColumn('last_login');
            $table->dropColumn('programming_language');
            $table->dropColumn('vk_link');
            $table->dropColumn('fb_link');
        });
    }
}
