<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesin', function (Blueprint $table) {
            $table->string('mesin_nama',100);
            $table->string('mesin_nomor',100);
            $table->integer('mesin_spindle');
            $table->integer('hapus')->default(1);
            $table->increments('id');
            
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            
            $table->index('mesin_nama');
             $table->index('mesin_nomor');
            $table->index('hapus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mesin');
    }
}
