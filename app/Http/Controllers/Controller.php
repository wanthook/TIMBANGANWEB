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
                    $ret .= '<li>';
                    $ret .= '<a href="#"><i class="'.$modul->icon.' fa-fw"></i> '.$modul->nama.'<span class="fa arrow"></span></a>';
                    $ret .= '<ul class="nav nav-second-level">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                }
                else
                {
                    $route = "";
                    if(!empty($modul->param))
                    {
                        $route = route($modul->route,explode('.',$modul->param));
                    }
                    else
                    {
                        $route = route($modul->route);
                    }
                    $ret .= '<li class="active"><a href="'.$route.'"><i class="'.$modul->icon.' fa-fw"></i> '.$modul->nama.'</a></li>';
                }
            }
            else
            {
                if($child!="")
                {
                    $ret .= '<li>';
                    $ret .= '<a href="#"><i class="'.$modul->icon.' fa-fw"></i> '.$modul->nama.'<span class="fa arrow"></span></a>';
                    $ret .= '<ul class="nav nav-second-level">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                    //$ret .= '<li><a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
                else
                {
                    $route = "";
                    if(!empty($modul->param))
                    {
                        $route = route($modul->route,explode('.',$modul->param));
                    }
                    else
                    {
                        $route = route($modul->route);
                    }
                    $ret .= '<li><a href="'.$route.'"><i class="'.$modul->icon.' fa-fw"></i> '.$modul->nama.'</a></li>';
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
                    $ret .= '<a href="#"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a>';
                    $ret .= '<ul style="display: block">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                }
                else
                {
                    $route = "";
                    if(!empty($modul->param))
                    {
                        $route = route($modul->route,explode('.',$modul->param));
                    }
                    else
                    {
                        $route = route($modul->route);
                    }
                    $ret .= '<li class="active"><a href="'.$route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
            }
            else
            {
                if($child!="")
                {
                    $ret .= '<li class="dropdown">';
                    $ret .= '<a href="#"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a>';
                    $ret .= '<ul style="display: block">';
                    $ret .= $child;
                    $ret .= '</ul></li>';
                    //$ret .= '<li><a href="'.$modul->route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
                else
                {
                    $route = "";
                    if(!empty($modul->param))
                    {
                        $route = route($modul->route,explode('.',$modul->param));
                    }
                    else
                    {
                        $route = route($modul->route);
                    }
                    $ret .= '<li><a href="'.$route.'"><span class="'.$modul->icon.'"></span> '.$modul->nama.'</a></li>';
                }
                
            }            
        }
        
        return $ret;
    }
}
