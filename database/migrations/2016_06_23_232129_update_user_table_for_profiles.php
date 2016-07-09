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
            $table->date('date_of_birth')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('place_of_study', 255)->nullable();
            $table->string('profession', 255)->nullable();
            $table->timestamp('last_login');
            $table->integer('programming_language')->nullable()->unsigned();
            $table->string('vk_link', 255)->nullable();
            $table->string('fb_link', 255)->nullable();
            $table->string('email_verification_code', 13)->nullable();

            $table->foreign('programming_language')
                ->references('id')
                ->on('programming_languages')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
            $table->dropForeign('users_programming_language_foreign');

            $table->dropColumn('date_of_birth');
            $table->dropColumn('avatar');
            $table->dropColumn('place_of_study');
            $table->dropColumn('profession');
            $table->dropColumn('last_login');
            $table->dropColumn('programming_language');
            $table->dropColumn('vk_link');
            $table->dropColumn('fb_link');
            $table->dropColumn('email_verification_code');
        });
    }
}
