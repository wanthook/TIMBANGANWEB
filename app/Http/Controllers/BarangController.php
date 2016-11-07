<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\CreateBarangRequest;
use App\Barang as Barang;
use Auth;
use Yajra\Datatables\Datatables;

class BarangController extends Controller
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
        
        $this->menu   = $this->parentMenu('jenisbarang');
    }
    
    public function index()
    {
        return view('admin.barang_list',['menu'=>$this->menu]);
    }
    
    public function add()
    {
        $var = new Barang;
        return view('admin.barang_form',compact('var'))->with(['menu'=>$this->menu]);
    }
    
    public function edit($id)
    {
        $var   = Barang::where('id_barang',$id)->first();
        return view('admin.barang_form',compact('var'))->with(['menu'=>$this->menu]);
    }
    
    public function save(CreateBarangRequest $request)
    {
        $data   = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['modified_by'] = Auth::user()->id;
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['modify_date'] = date('Y-m-d H:i:s');
        Barang::create($data);
        
        return redirect()->route('jenisbarang');
    }
    
    
    
    public function change($id, CreateBarangRequest $request)
    {
       $edit    = Barang::where('id_barang',$id)->first();
       
       $data   = $request->all();
       $data['modified_by'] = Auth::user()->id;
       $data['modify_date'] = date('Y-m-d H:i:s');
       
       
       $edit->fill($data)->save();
       
       return redirect()->route('jenisbarang');
    }
    
    public function softdelete($id, Request $request)
    {
        $edit    = Barang::where('id_barang',$id)->first();
        
        $data    = $request->all();
        
        $data['hapus']    = '0';
        $data['modified_by'] = Auth::user()->id;
        $data['modify_date'] = date('Y-m-d H:i:s');
        
        $edit->fill($data)->save();
        
        echo json_encode(array('status' => 1, 'msg' => 'Data berhasil dihapus!!!'));
    }
    
    public function dataTables(Request $request)
    {
        $data   = Barang::where('hapus','1');
        
        return  Datatables::of($data)
                ->addColumn('action',function($data)
                {
                    $str  = '<a href="'.route("jenisbarang.ubah",$data->id_barang).'" class="editrow btn btn-default"><i class="fa fa-edit"></i></a>&nbsp;';
                    $str .= '<a href="'.route("jenisbarang.hapus",$data->id_barang).'" class="deleterow btn btn-default"><i class="fa fa-minus-circle"></i></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id_barang}}')
                ->make(true);
    }
    
    public function select2(Request $request)
    {
        $ret    = array();
        $datas  = array();
        if($request->input('id'))
        {
            $datas = Barang::where('id_barang',$request->input('id'))->whereHapus('1');
        }
        else
        {
            $datas = Barang::where(function($query) use ($request)
                               {
                                    $query->where('nama_barang','like','%'.$request->input('q').'%');
                                    $query->orWhere('kode','like','%'.$request->input('q').'%');
                               })->whereHapus('1');
        }
        $datas = $datas->get()->toArray();
        
        foreach($datas as $data)
        {
            $ret[] = array('id' => $data['id_barang'], 'text' => $data['kode'].' - '.$data['nama_barang']);
        }
        
        echo json_encode($ret);
    }
}
