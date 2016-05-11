<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests\CreateModuleRequest;
use App\Http\Controllers\Controller;

use App\Module;
use Auth;
use Yajra\Datatables\Datatables;

class ModuleController extends Controller
{
    private $menu;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->menu   = $this->parentMenu('module');
    }
    
    public function show()
    {
        return view('admin.module.show',['menu'=>$this->menu]);
    }
    
    public function create()
    {
        return view('admin.module.create',['menu'=>$this->menu]);
    }
    
    public function edit($id, Module $module)
    {
        $module   = $module->whereId($id)->first();
        
        return view('admin.module.edit',compact('module'))->with(['menu'=>$this->menu]);
    }
    
    public function save(CreateModuleRequest $request, Module $module)
    {
        $data   = $request->all();
        $data['password']   = bcrypt($data['password']);
        $data['created_by'] = Auth::module()->id;
        $data['updated_by'] = Auth::module()->id;
        $module->create($data);
        
        return redirect()->route('module.tabel');
    }
    
    public function update($id, Request $request, Module $module)
    {
       $edit    = $module->whereId($id)->first();
       
       $edit->fill($request->input())->save();
       
       return redirect()->route('module.tabel');
    }
    
    public function softdelete($id, Request $request, Module $module)
    {
        $edit    = $module->whereId($id)->first();
        
        $data    = $request->input();
        
        $data['hapus']    = '0';
        $data['updated_by'] = Auth::module()->id;
        
        $edit->fill($data)->save();
        
        echo json_encode(array('status' => 1, 'msg' => 'Data berhasil dihapus!!!'));
    }
    
    public function dataTables(Request $request, Module $module)
    {
        $data   = $module->where('hapus','1');
        
        return  Datatables::of($data)
                ->addColumn('action',function($data)
                {
                    $str  = '<a href="'.route("module.ubah",$data->id).'" class="editrow btn btn-default"><span class="icon-edit"></span></a>&nbsp;';
                    $str .= '<a href="'.route("module.hapus",$data->id).'" class="deleterow btn btn-default"><span class="icon-remove"></span></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
    public function selectdua(Request $request, Module $module)
    {
        $ret    = array();
        $datas  = array();
        if($request->input('id'))
        {
            $id     = $request->input('id');
            
//            $datas = $module->where('id',$id);
            if(stristr($id,','))
            {
                $datas = $module->whereIn('id',  explode(',',$request->input('id')));
            }
            else
            {
                $datas = $module->where('id',$id);
            }
            
        }
        else
        {
            $datas = $module->where(function($query) use ($request)
                               {
                                    $query->where('nama','like','%'.$request->input('q').'%');
                               });
        }
        $datas = $datas->get()->toArray();
        
        foreach($datas as $data)
        {
            $ret[] = array('id' => $data['id'], 'text' => $data['nama']);
        }
        
        echo json_encode($ret);
    }
}
