<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public $timestamps = false;
    
    protected $table = 'jenis_barang';
    
    protected $primaryKey   = 'id_barang';
    
    protected $fillable = [
        'nama_barang', 'kode', 'mesin_spindle', 'created_by', 'modified_by', 'hapus', 'create_date','modify_date'
    ];


    protected $dates = ['create_date','modify_date'];
    
    public function timbangan()
    {
        return $this->hasMany('App\Timbangan','id_barang','id_barang');
    }
}
