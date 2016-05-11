<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SnapDetail extends Model
{
    protected $table = 'mesin';
    
    protected $fillable = [
        'waktu', 'left', 'left_snap', 'right', 'right_snap', 'total_breaks', 'total_snap', 'rr_pos', 'speed', 'snap_id', 'created_by', 'updated_by', 'hapus'
    ];


    protected $dates = ['created_at','modified_at'];
    
    public function snap()
    {
        return $this->belongsTo('App\Snap');
    }
}
