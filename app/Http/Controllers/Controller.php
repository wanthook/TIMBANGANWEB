<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Module;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function parentMenu($selected="")
    {
        $ret = "";
        
        $moduls = Module::whereHas('users',function($q)
        {
            $q->where('users.id',Auth::user()->id);
        })
        ->where([
            ['module.parent','0'],
            ['module.hapus','1']
        ])
        ->orderBy('order','ASC')
        ->get();
        
        foreach($moduls as $modul)
        {
            $child  = $this->childModule($modul->id,$selected);
            
            if($modul->selected == $selected)
            {
                if($child!="")
                {
                    $ret .= '<li class="dropdown active">';
                    $ret .= '<a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a>';
                    $ret .= '<ul style="display: block">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                }
                else
                {
                    $ret .= '<li class="active"><a href="'.route($modul->route).'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
            }
            else
            {
                if($child!="")
                {
                    $ret .= '<li class="dropdown">';
                    $ret .= '<a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a>';
                    $ret .= '<ul style="display: block">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                    //$ret .= '<li><a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
                else
                {
                    $ret .= '<li><a href="'.route($modul->route).'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
                
            }            
            
        }
        
        return $ret;
    }
    
    private function childModule($id,$selected)
    {
        $ret = "";
        
        $moduls = Module::whereHas('users',function($q)
        {
            $q->where('users.id',Auth::user()->id);
        })
        ->where([
            ['module.parent',$id],
            ['module.hapus','1']
        ])
        ->orderBy('order','ASC')
        ->get();
        
        foreach($moduls as $modul)
        {
            $child  = $this->childModule($modul->id,$selected);
            
            if($modul->selected == $selected)
            {
                if($child!="")
                {
                    $ret .= '<li class="dropdown active">';
                    $ret .= '<a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a>';
                    $ret .= '<ul style="display: block">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                }
                else
                {
                    $ret .= '<li class="active"><a href="'.route($modul->route).'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
            }
            else
            {
                if($child!="")
                {
                    $ret .= '<li class="dropdown">';
                    $ret .= '<a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a>';
                    $ret .= '<ul style="display: block">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                    //$ret .= '<li><a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
                else
                {
                    $ret .= '<li><a href="'.route($modul->route).'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
                
            }            
        }
        
        return $ret;
    }
}
