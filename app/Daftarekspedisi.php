<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Daftarekspedisi extends Model
{
    public $timestamps = false;
    
    protected $table = 'daftar_ekspedisi';
    
    protected $fillable = [
        'no_pol', 
        'relasi', 
        'tanggal_pesan', 
        'nama_supir',
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
        'tanggal_pesan' => 'date'
    ];

    protected $dates = [
        'create_date',
        'modify_date'
    ];
    
    public function timbangan()
    {
        return $this->hasMany('App\Timbangan','timbangan_id','timbangan_id');
    }
    
    public function getTanggalPesanAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    public function formTanggalPesanAttribute($value)
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
