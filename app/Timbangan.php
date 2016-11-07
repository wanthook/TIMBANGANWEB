<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timbangan extends Model
{
    public $timestamps = false;
    
    protected $table = 'timbangan';
    
    protected $primaryKey   = 'timbangan_id';
    
    protected $fillable = [
        'tanggal_masuk', 
        'tanggal_keluar', 
        'tiket', 
        'no_pol',
        'relasi',
        'id_barang', 
        'nama_supir',
        'berat_gross',
        'berat_tara', 
        'berat_netto',
        'jam_masuk',
        'jam_keluar', 
        'catatan',
        'print',
        'sj', 
        'po',
        'type',
        'alasan', 
        'timbang_in',
        'timbang_out', 
        'hapus', 
        'created_by', 
        'modified_by',
        'create_date',
        'modify_date'
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date'
    ];

    protected $dates = [
        'create_date',
        'modify_date'
    ];
    
    public function barang()
    {
        return $this->hasMany('App\Barang','id_barang','id_barang');
    }
    
    public function getTanggalMasukAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    public function getTanggalKeluarAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    public function formTanggalMasukAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    public function formTanggalKeluarAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    /**
     * The connection name for the model.
     *
     * @var string
     */
//    protected $connection = 'connection-name';
}
