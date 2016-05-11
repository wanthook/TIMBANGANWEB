<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) 
        {
            $table->string('photo',50);
            $table->string('username', 50)->unique();
            $table->string('password', 60);
            $table->string('name');
            $table->string('email');            
            $table->rememberToken();
            $table->string('type',50);
            $table->increments('id');
//            $table->integer('departemen_id')->unsigned();
            $table->integer('hapus')->default(1);
            
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            
//            $table->foreign('departemen_id')
//                  ->references('id')->on('departemen')
//                  ->onDelete('cascade');
            
            $table->index('username');
            $table->index('password');
            $table->index('hapus');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
