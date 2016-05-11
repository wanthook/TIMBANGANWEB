<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snap extends Model
{
    protected $table = 'snap';
    
    protected $fillable = [
        'snap_tanggal', 'mesin_id', 'snap_shift', 'created_by', 'updated_by', 'hapus'
    ];
    
    protected $dates = ['created_at','modified_at'];
    
    public function mesin()
    {
        return $this->belongsTo('App\Mesin');
    }
}
