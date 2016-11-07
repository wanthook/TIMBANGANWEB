<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snap', function (Blueprint $table) {
            $table->date('snap_tanggal');
            $table->integer('mesin_id')->unsigned();
            $table->string('snap_shift');
            $table->decimal('avg_left',10,2);
            $table->decimal('avg_lsnap',10,2);
            $table->decimal('avg_right',10,2);
            $table->decimal('avg_rsnap',10,2);
            $table->decimal('avg_totalbreaks',10,2);
            $table->decimal('avg_totalsnap',10,2);
            $table->decimal('avg_rest',10,2);
            $table->decimal('avg_first',10,2);
            $table->decimal('avg_last',10,2);
            $table->integer('hapus')->default('1');
            
            $table->increments('id');
            
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            
            $table->index('snap_tanggal');
            $table->index('snap_shift');
            $table->index('hapus');
            
            $table->foreign('mesin_id')
                  ->references('id')->on('mesin')
                  ->onDelete('cascade');
        });
        
        Schema::create('snap_detail', function (Blueprint $table) {  
            $table->integer('no');
            $table->time('waktu');
            $table->integer('rest');
            $table->integer('left');
            $table->decimal('left_snap',10,2);
            $table->integer('right');
            $table->decimal('right_snap',10,2);
            $table->integer('total_breaks');
            $table->decimal('total_snap',10,2);
            $table->decimal('rr_pos',10,2);
            $table->integer('speed');
            $table->integer('snap_id')->unsigned();
            $table->integer('hapus')->default('1');
            
            $table->increments('id');
            
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at');
            
            $table->index('no');
            $table->index('waktu');
            $table->index('hapus');
            
            $table->foreign('snap_id')
                  ->references('id')->on('snap')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('snap');
        Schema::drop('snap_detail');
    }
}
