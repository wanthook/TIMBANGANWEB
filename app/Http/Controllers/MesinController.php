<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateMesinRequest;
use App\Http\Controllers\Controller;

use App\Mesin;
use Auth;
use Yajra\Datatables\Datatables;

class MesinController extends Controller
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
        
        $this->menu   = $this->parentMenu('mesin');
    }
    
    public function show()
    {
        return view('admin.mesin.show',['menu'=>$this->menu]);
    }
    
    public function create()
    {
        return view('admin.mesin.create',['menu'=>$this->menu]);
    }
    
    public function edit($id, Mesin $mesin)
    {
        $mesin   = $mesin->whereId($id)->first();
        
        return view('admin.mesin.edit',compact('mesin'))->with(['menu'=>$this->menu]);
    }
    
    public function save(CreateMesinRequest $request, Mesin $mesin)
    {
        $data   = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $mesin->create($data);
        
        return redirect()->route('mesin.tabel');
    }
    
    public function update($id, Request $request, Mesin $mesin)
    {
       $edit    = $mesin->whereId($id)->first();
       
       $edit->fill($request->input())->save();
       
       return redirect()->route('mesin.tabel');
    }
    
    public function softdelete($id, Request $request, Mesin $mesin)
    {
        $edit    = $mesin->whereId($id)->first();
        
        $data    = $request->input();
        
        $data['hapus']    = '0';
        $data['updated_by'] = Auth::user()->id;
        
        $edit->fill($data)->save();
        
        echo json_encode(array('status' => 1, 'msg' => 'Data berhasil dihapus!!!'));
    }
    
    public function dataTables(Request $request, Mesin $mesin)
    {
        $data   = $mesin->where('hapus','1');
        
        return  Datatables::of($data)
                ->addColumn('action',function($data)
                {
                    $str  = '<a href="'.route("mesin.ubah",$data->id).'" class="editrow btn btn-default"><span class="icon-edit"></span></a>&nbsp;';
                    $str .= '<a href="'.route("mesin.hapus",$data->id).'" class="deleterow btn btn-default"><span class="icon-remove"></span></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
    public function selectdua(Request $request, Mesin $mesin)
    {
        $ret    = array();
        $datas  = array();
        if($request->input('id'))
        {
            $datas = $mesin->where('id',$request->input('id'));
        }
        else
        {
            $datas = $mesin->where(function($query) use ($request)
                               {
                                    $query->where('mesin_nama','like','%'.$request->input('q').'%');
                               });
        }
        $datas = $datas->get()->toArray();
        
        foreach($datas as $data)
        {
            $ret[] = array('id' => $data['id'], 'text' => $data['mesin_nama'], 'mesin_spindle' => $data['mesin_spindle']);
        }
        
        echo json_encode($ret);
    }
}
