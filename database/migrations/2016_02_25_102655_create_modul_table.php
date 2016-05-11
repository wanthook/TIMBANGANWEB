<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module', function (Blueprint $table) {
            $table->string('nama',100);
            $table->string('desc',100);
            $table->string('route',100);
            $table->string('param',100);
            $table->integer('parent');
            $table->string('selected',100);
            $table->string('icon',50)->nullable();
            $table->integer('order')->nullable();
            $table->integer('hapus')->default('1');
            $table->increments('id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            
            $table->index('hapus');
            $table->index('nama');
            $table->index('order');
        });
        
        Schema::create('module_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('module_id')->unsigned();
            
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->foreign('module_id')
                  ->references('id')->on('module')
                  ->onDelete('cascade');
            
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
        Schema::drop('module');
        Schema::drop('module_user');
    }
}
