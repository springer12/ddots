<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('content', 3000);
            $table->string('stripped_content', 3000);
            $table->unsignedInteger('subdomain_id')->nullable();
            $table->boolean('show_on_main')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subdomain_id')
                ->references('id')
                ->on('subdomains')
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
        Schema::drop('news');
    }
}