<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Http\Requests\CreateDaftarekspedisiRequest;
use App\Daftarekspedisi as Daftarekspedisi;
use App\Barang as Barang;
use Auth;
use Yajra\Datatables\Datatables;


class DaftarekspedisiController extends Controller
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
        
        $this->menu   = $this->parentMenu('daftarekspedisi');
    }
    
    public function index()
    {
        return view('admin.daftarekspedisi_list',['menu'=>$this->menu]);
    }
    
    public function add()
    {
        $var = new Daftarekspedisi;
        return view('admin.daftarekspedisi_form',compact('var'))->with(['menu'=>$this->menu]);
    }
    
    public function edit($id)
    {
        $var   = Daftarekspedisi::where('id',$id)->first();
         
       return view('admin.daftarekspedisi_form',compact('var'))->with(['menu'=>$this->menu]);
    }
    
    public function save(CreateDaftarekspedisiRequest $request)
    {
        $data   = $request->all();
        if(!empty($data['tanggal_pesan']))
        {
            $data['tanggal_pesan'] = Carbon::createFromFormat('d-m-Y',$data['tanggal_pesan'])->toDateString();
        }
        else
        {
            unset($data['tanggal_pesan']);
        }
        $data['created_by'] = Auth::user()->id;
        $data['modified_by'] = Auth::user()->id;
        $data['create_date'] = Carbon::now();
        $data['modify_date'] = Carbon::now();
        Daftarekspedisi::create($data);
        
        return redirect()->route('daftarekspedisi')->with('msg','Data berhasil disimpan.');;
    }
    
    
    
    public function change($id, CreateDaftarekspedisiRequest $request)
    {
        $edit    = Daftarekspedisi::where('id',$id)->first();

        $data   = $request->all();
        if(!empty($data['tanggal_pesan']))
        {
            $data['tanggal_pesan'] = Carbon::createFromFormat('d-m-Y',$data['tanggal_pesan'])->toDateString();
        }
        else
        {
            unset($data['tanggal_pesan']);
        }
       
        $data['modified_by'] = Auth::user()->id;
        $data['modify_date'] = Carbon::now();
        $edit->fill($data)->save();

        return redirect()->route('daftarekspedisi')->with('msg','Data berhasil dirubah.');
       
    }
    
    public function softdelete($id, CreateDaftarekspedisiRequest $request)
    {
        $edit    = Daftarekspedisi::where('id',$id)->first();
        
        $data    = $request->all();
        
        $data['hapus']    = '0';
        $data['modified_by'] = Auth::user()->id;
        $data['modify_date'] = Carbon::now();
        
        $edit->fill($data)->save();
        
        echo json_encode(array('status' => 1, 'msg' => 'Data berhasil dihapus!!!'));
    }
    
    public function dataTables(Request $request)
    {
        $req    = $request->all();
        
        $datas   = Daftarekspedisi::with('timbangan');      
        
        $datas->where('hapus','1');
        
        if(!empty($req['txtSearch']))
        {
            $datas->where(function($q) use ($req)
            {
                $q->where('no_pol','like','%'.$req['txtSearch'].'%');
                $q->orWhere('nama_supir','like','%'.$req['txtSearch'].'%');
            });
        }    
        
        if(!empty($req['cmbRelasi']))
        {
            $datas->where('relasi',$req['cmbRelasi']);
        } 
//        
        if(!empty($req['txtTanggalDaftar']))
        {
            $sdt = Carbon::createFromFormat('d-m-Y',$req['txtTanggalDaftar']);
            
            $datas->where('tanggal_pesan',$sdt->toDateString());
        }
        
        $datas->orderBy('id','desc');
        
        return  Datatables::of($datas)
                ->addColumn('action',function($datas)
                {
                    $str  = '<a href="'.route("daftarekspedisi.ubah",$datas->id).'" class="editrow btn btn-default"><i class="fa fa-edit"></i></a>&nbsp;';
                    $str .= '<a href="'.route("daftarekspedisi.hapus",$datas->id).'" class="deleterow btn btn-default"><i class="fa fa-minus-circle"></i></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
}
