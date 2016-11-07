<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    public $timestamps = false;
    
    protected $table = 'mutasi';
    
    protected $fillable = [
        'in_out',
        'tanggal',
        'tipe',
        'no_container',
        'jenis', 
        'partai', 
        'tiket',
        'no_pol',
        'bal_list', 
        'bal_terima',
        'bal_selisih', 
        'packing_tarabl', 
        'packing_brutto', 
        'packing_tara',
        'packing_subnetto', 
        'timbangan_brutto', 
        'timbangan_tara', 
        'timbangan_netto',
        'timbanganman_brutto', 
        'timbanganman_tara', 
        'timbanganman_netto', 
        'netto',
        'selisih', 
        'persen', 
        'keterangan', 
        'timbangan_id',
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
        'tanggal' => 'date'
    ];

    protected $dates = [
        'create_date',
        'modify_date'
    ];
    
    public function timbangan()
    {
        return $this->hasMany('App\Timbangan','timbangan_id','timbangan_id');
    }
    
    public function getTanggalAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    public function formTanggalAttribute($value)
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
