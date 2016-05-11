<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $table = 'mesin';
    
    protected $fillable = [
        'mesin_nama', 'mesin_nomor', 'mesin_spindle', 'created_by', 'updated_by', 'hapus'
    ];


    protected $dates = ['created_at','modified_at'];
    
}
