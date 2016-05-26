<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateSnapRequest;
use App\Http\Controllers\Controller;

use App\Snap as Snap;
use App\SnapDetail as SnapDetail;
use Auth;
use Yajra\Datatables\Datatables;

class SnapController extends Controller
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
        
        $this->menu   = $this->parentMenu('snap');
    }
    
    public function show()
    {
        return view('admin.snap.show',['menu'=>$this->menu]);
    }
    
    public function create()
    {
        $data = new Snap;
        $data->snap_tanggal = date('Y-m-d');
        return view('admin.snap.create',compact('data'))->with(['menu'=>$this->menu]);
    }
    
    public function edit($id, Snap $snap)
    {
        $snap   = $snap->whereId($id)->first();
        
        return view('admin.snap.edit',compact('snap'))->with(['menu'=>$this->menu]);
    }
    
    public function save(CreateSnapRequest $request, Snap $snap)
    {
        $data   = $request->all();
                
//        print_r($data);
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $save = $snap->create($data);
        
        $detail = array();
        
        if(!empty($data['waktu']) && is_array($data['waktu']))
        {
            
        }
        
//        return redirect()->route('snap.tabel');
    }
    
    public function update($id, Request $request, Snap $snap)
    {
       $edit    = $snap->whereId($id)->first();
       
       $edit->fill($request->input())->save();
       
       return redirect()->route('snap.tabel');
    }
    
    public function softdelete($id, Request $request, Snap $snap)
    {
        $edit    = $snap->whereId($id)->first();
        
        $data    = $request->input();
        
        $data['hapus']    = '0';
        $data['updated_by'] = Auth::user()->id;
        
        $edit->fill($data)->save();
        
        echo json_encode(array('status' => 1, 'msg' => 'Data berhasil dihapus!!!'));
    }
    
    public function dataTables(Request $request)
    {
        $data   = Snap::where('hapus','1')->with('mesin')->get();
        
        return  Datatables::of($data)
                ->addColumn('action',function($data)
                {
                    $str  = '<a href="'.route("snap.ubah",$data->id).'" class="editrow btn btn-default"><span class="icon-edit"></span></a>&nbsp;';
                    $str .= '<a href="'.route("snap.hapus",$data->id).'" class="deleterow btn btn-default"><span class="icon-remove"></span></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
    public function selectdua(Request $request, Snap $snap)
    {
        $ret    = array();
        $datas  = array();
        if($request->input('id'))
        {
            $datas = $snap->where('id',$request->input('id'));
        }
        else
        {
            $datas = $snap->where(function($query) use ($request)
                               {
                                    $query->where('snap_nama','like','%'.$request->input('q').'%');
                               });
        }
        $datas = $datas->get()->toArray();
        
        foreach($datas as $data)
        {
            $ret[] = array('id' => $data['id'], 'text' => $data['snap_nama']);
        }
        
        echo json_encode($ret);
    }
}
