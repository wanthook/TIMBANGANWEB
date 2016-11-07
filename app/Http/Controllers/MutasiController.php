<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Http\Requests\CreateMutasiRequest;
use App\Mutasi as Mutasi;
use App\Barang as Barang;
use App\Timbangan as Timbangan;
use Auth;
use Yajra\Datatables\Datatables;


class MutasiController extends Controller
{
    private $menu;
    
    private $route;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Route $route)
    {
        $this->middleware('auth');
        
        $this->menu   = $this->parentMenu('mutasi'.$route->getParameter('inout').$route->getParameter('param'));
    }
    
    public function index($inout,$param)
    {
//        echo $param;
        return view('admin.mutasi_list',['menu'=>$this->menu,'inout'=>$inout,'param'=>$param]);
    }
    
    public function add($inout,$param,$tipe)
    {
        $var = new Mutasi;
        $var['tipe']    = $tipe;
//        $var->tanggal = Carbon::now();
        return view('admin.mutasi_form',compact('var'))->with(['menu'=>$this->menu,'inout'=>$inout,'param'=>$param]);
    }
    
    public function edit($inout,$param,$id)
    {
        $var   = Mutasi::where('id',$id)->first();
         
       return view('admin.mutasi_form',compact('var'))->with(['menu'=>$this->menu,'inout'=>$inout,'param'=>$param]);
    }
    
    public function save($inout,$param,CreateMutasiRequest $request)
    {
        $data   = $request->all();
        $data['in_out'] = $inout;
        if(!empty($data['tanggal']))
        {
            $data['tanggal'] = Carbon::createFromFormat('d-m-Y',$data['tanggal'])->toDateString();
        }
        else
        {
            unset($data['tanggal']);
        }
        $data['created_by'] = Auth::user()->id;
        $data['modified_by'] = Auth::user()->id;
        $data['create_date'] = Carbon::now();
        $data['modify_date'] = Carbon::now();
        Mutasi::create($data);
        
        return redirect()->route('mutasi',[$inout,$param])->with('msg','Data berhasil disimpan.');;
    }
    
    
    
    public function change($inout,$param,$id, CreateMutasiRequest $request)
    {
        $edit    = Mutasi::where('id',$id)->first();

        $data   = $request->all();
        
        $data['in_out'] = $inout;
        if(!empty($data['tanggal']))
        {
            $data['tanggal'] = Carbon::createFromFormat('d-m-Y',$data['tanggal'])->toDateString();
        }
        else
        {
            unset($data['tanggal']);
        }       
        $data['modified_by'] = Auth::user()->id;
        $data['modify_date'] = Carbon::now();
        $edit->fill($data)->save();

        return redirect()->route('mutasi',[$inout,$param])->with('msg','Data berhasil dirubah.');
       
    }
    
    public function softdelete($inout,$param,$id, CreateMutasiRequest $request)
    {
        $edit    = Mutasi::where('id',$id)->first();
        
        $data    = $request->all();
        
        $data['hapus']    = '0';
        $data['modified_by'] = Auth::user()->id;
        $data['modify_date'] = Carbon::now();
        
        $edit->fill($data)->save();
        
        echo json_encode(array('status' => 1, 'msg' => 'Data berhasil dihapus!!!'));
    }
    
    public function dataTables($inout,$param, Request $request)
    {
        $req    = $request->all();
        
        $datas   = Mutasi::with('timbangan');   
        
        if(!empty($req['txtSearch']))
        {
            $datas->where(function($q) use ($req)
            {
                $q->where('no_pol','like','%'.$req['txtSearch'].'%');
                $q->orWhere('tiket','like','%'.$req['txtSearch'].'%');
            });
        }    
        
        if(!empty($req['cmbPartai']))
        {
            $datas->where('partai','like','%'.$req['cmbPartai'].'%');
        } 
//        
        if(!empty($req['txtTanggalStart']))
        {
            $sdt = Carbon::createFromFormat('d-m-Y',$req['txtTanggalStart']);
            
            if(!empty($req['txtTanggalEnd']))
            {
                $edt = Carbon::createFromFormat('d-m-Y',$req['txtTanggalEnd']);
                
                $datas->where(function($q) use($sdt,$edt)
                {
                    $q->whereBetween('tanggal',[$sdt->toDateString(),$edt->toDateString()]);
                });
            }
            
            $datas->where('tanggal',$sdt->toDateString());
        }
//        echo $request->tipe;
        $datas->where('tipe',$request->tipe);
        $datas->where('jenis',$param);           
        $datas->where('hapus','1');
        $datas->where('in_out',$inout);
        $datas->orderBy('id','desc');
//        echo $datas->toSql();
        return  Datatables::of($datas)
                ->addColumn('action',function($datas) use($inout,$param)
                {
                    $str  = '<a href="'.route("mutasi.ubah",[$inout,$param,$datas->id]).'" class="editrow btn btn-default"><i class="fa fa-edit"></i></a>&nbsp;';
                    $str .= '<a href="'.route("mutasi.hapus",[$inout,$param,$datas->id]).'" class="deleterow btn btn-default"><i class="fa fa-minus-circle"></i></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
    public function autopartai($inout,$param,Request $request)
    {
        $ret    = array();
        $datas  = array();
        
        if($request->input('q'))
        {
            $datas = Mutasi::select('partai')->where('partai','like','%'.$request->input('q').'%')->groupBy('partai');
        
            $datas = $datas->orderBy('partai','asc')->get()->toArray();

            foreach($datas as $data)
            {
                $ret[] = array('id' => $data['partai'], 'value' => $data['partai']);
            }
        }
            
        
        echo json_encode($ret);
    }
}
