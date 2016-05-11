<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['name']; 
    protected $table = 'module';
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
