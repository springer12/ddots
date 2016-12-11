<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorSubdomainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_subdomain', function (Blueprint $table) {
            $table->integer('sponsor_id')->unsigned();
            $table->integer('subdomain_id')->unsigned();
            $table->foreign('sponsor_id')
                ->references('id')->on('sponsors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('subdomain_id')
                ->references('id')->on('subdomains')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['sponsor_id', 'subdomain_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sponsor_subdomain');
    }
}
