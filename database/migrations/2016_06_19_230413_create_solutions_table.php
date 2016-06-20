<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('state',        ['new', 'reserved', 'received', 'tested', 'rejected']);
            $table->enum('status',       ['CE', 'FF', 'NC', 'CC', 'CT', 'UE'])->nullable();
            $table->enum('testing_mode', ['full', 'first_fail', 'one']);
            $table->string('message')->nullable();
            
            $table->unsignedInteger('problem_id');
            $table->foreign('problem_id')
                ->references('id')->on('problems')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('programming_language_id');
            $table->foreign('programming_language_id')
                ->references('id')->on('programming_languages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->unsignedInteger('testing_server_id');
            $table->foreign('testing_server_id')
                ->references('id')->on('testing_servers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() 
    {
        Schema::drop('solutions');
    }
}
