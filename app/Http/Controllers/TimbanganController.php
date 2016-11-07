<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Http\Requests\CreateTimbanganRequest;
use App\Http\Requests\CreateUploadtimbanganRequest;

use App\Timbangan as Timbangan;
use App\Barang as Barang;
use Auth;
use Yajra\Datatables\Datatables;
use Excel;


class TimbanganController extends Controller
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
        
        $this->menu   = $this->parentMenu('timbangan');
    }
    
    public function index()
    {
        return view('admin.timbangan_list',['menu'=>$this->menu]);
    }
    
    public function add()
    {
        $var = new Timbangan;
        return view('admin.timbangan_form',compact('var'))->with(['menu'=>$this->menu]);
    }
    
    public function upload()
    {
        $var = new Timbangan;
        return view('admin.timbangan_formupload',compact('var'))->with(['menu'=>$this->menu]);
    }
    
    public function edit($id)
    {
        $var   = Timbangan::where('timbangan_id',$id)->first();
         
       return view('admin.timbangan_form',compact('var'))->with(['menu'=>$this->menu]);
    }
    
    public function save(CreateTimbanganRequest $request)
    {
        $data   = $request->all();
        
        if(!empty($data['tanggal_masuk']))
        {
            $data['tanggal_masuk'] = Carbon::createFromFormat('d-m-Y',$data['tanggal_masuk'])->toDateString();
        }
        else
        {
            unset($data['tanggal_masuk']);
            unset($data['jam_masuk']);
        }
        
        if(!empty($data['tanggal_keluar']))
        {
            $data['tanggal_keluar'] = Carbon::createFromFormat('d-m-Y',$data['tanggal_keluar'])->toDateString();
        }
        else
        {
            unset($data['tanggal_keluar']);
            unset($data['jam_keluar']);
        }
        
        $data['tiket']   = $this->generateTicket($data['id_barang']);
        $data['type']    = $edit->type;
        $data['print']   = $edit->print;
        $data['timbang_in']    = $edit->timbang_in;
        $data['timbang_out']    = $edit->timbang_out;       
        
        $data['created_by'] = Auth::user()->id;
        $data['modified_by'] = Auth::user()->id;
        $data['create_date'] = Carbon::now();
        $data['modify_date'] = Carbon::now();
        Timbangan::create($data);
        
        return redirect()->route('timbangan')->with('msg','Data berhasil disimpan.');
    }
    
    
    
    public function change($id, CreateTimbanganRequest $request)
    {
       $edit    = Timbangan::where('timbangan_id',$id)->first();
       
       $data   = $request->all();
       if(!empty($data['tanggal_masuk']))
       {
           $data['tanggal_masuk'] = Carbon::createFromFormat('d-m-Y',$data['tanggal_masuk'])->toDateString();
       }
       else
       {
           unset($data['tanggal_masuk']);
           unset($data['jam_masuk']);
       }
       if(!empty($data['tanggal_keluar']))
       {
           $data['tanggal_keluar'] = Carbon::createFromFormat('d-m-Y',$data['tanggal_keluar'])->toDateString();
       }
       else
       {
           unset($data['tanggal_keluar']);
           unset($data['jam_keluar']);
       }
       
       
       if($data['id_barang']!=$edit->id_barang)
       {
           $data['tiket']   = $this->generateTicket($data['id_barang']);
           $data['type']    = $edit->type;
           $data['print']   = $edit->print;
           $data['timbang_in']    = $edit->timbang_in;
           $data['timbang_out']    = $edit->timbang_out;
           $data['created_by'] = Auth::user()->id;
           $data['create_date'] = Carbon::now();
           
           $del['hapus']    = '0';
           $del['alasan']   = 'Tiket berubah, dari '.$edit->tiket.' menjadi '.$data['tiket'];
           $del['modified_by'] = Auth::user()->id;
           $del['modify_date'] = Carbon::now();
        
           $edit->fill($del)->save();
//           print_r($data);
           Timbangan::create($data);
        
            return redirect()->route('timbangan')->with('msg','Tiket berubah, dari '.$edit->tiket.' menjadi '.$data['tiket']);
           
       }
       else
       {
            $data['modified_by'] = Auth::user()->id;
            $data['modify_date'] = Carbon::now();
            $edit->fill($data)->save();
            
            return redirect()->route('timbangan')->with('msg','Data berhasil dirubah.');
       }
       
       //return redirect()->route('timbangan');
    }
    
    public function doupload(CreateUploadtimbanganRequest $request)
    {
        $data   = $request->all();
        
        if ($request->hasFile('timbangan_excel')) 
        {
            $file = $request->file('timbangan_excel');
            $filename   = crc32($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('uploads/excel/'), $filename);
            
            $bla = Excel::load(storage_path('uploads/excel/').$filename, function($reader)
            {
//                $reader->ignoreEmpty();
                $reader->skip(1);
//            })->get();    
            })->get()->toArray()[0];
//            print_r($bla);
            $filedata = array();
            
            for($i = 0 ; $i<count($bla) ; $i++)
            {
                $cek    = Timbangan::where([
                    ['tanggal_masuk','=',$bla[$i]['tanggal_masuk']],
                    ['tanggal_keluar','=',$bla[$i]['tanggal_keluar']],
                    ['jam_masuk','=',$bla[$i]['jam_masuk']],
                    ['jam_keluar','=',$bla[$i]['jam_keluar']],
                    ['no_pol','=',$bla[$i]['no_pol']],
                    ['relasi','=',$bla[$i]['relasi']],
                    ['timbang_in','=',$bla[$i]['kode_timbangan_masuk']],
                    ['timbang_out','=',$bla[$i]['kode_timbangan_keluar']]
                ])->count();
//                echo $i." - ".$cek."<br>";
                if($cek>0)
                {
                    continue;
                }
                
                $barang = Barang::where('kode',$bla[$i]['kode_barang'])->first();
                
                $print = 0;
                if(!empty($bla[$i]['tanggal_masuk']) && !empty($bla[$i]['tanggal_keluar']))
                {
                    $print = 1;
                }
                
                
                $filedata = array(
                    "tanggal_masuk"     => $bla[$i]['tanggal_masuk'],
                    "tanggal_keluar"    => $bla[$i]['tanggal_keluar'],
                    "tiket"             => $this->generateTicket($barang->id_barang),
                    "no_pol"            => $bla[$i]['no_pol'],
                    "relasi"            => $bla[$i]['relasi'],
                    "id_barang"         => $barang->id_barang,
                    "nama_supir"        => $bla[$i]['nama_supir'],
                    "berat_gross"       => $bla[$i]['berat_gross'],
                    "berat_tara"        => $bla[$i]['berat_tara'],
                    "berat_netto"       => $bla[$i]['berat_netto'],
                    "jam_masuk"         => $bla[$i]['jam_masuk'],
                    "jam_keluar"        => $bla[$i]['jam_keluar'],
                    "catatan"           => $bla[$i]['catatan'],
                    "print"             => $print,
                    "sj"                => $bla[$i]['sj'],
                    "po"                => $bla[$i]['po'],
                    "type"              => $bla[$i]['kode_tipe'],
                    "alasan"            => 'SYSTEM UPLOAD',
                    "created_by"        => Auth::user()->id,
                    "create_date"       => Carbon::now(),
                    "modified_by"       => Auth::user()->id,
                    "modify_date"       => Carbon::now(),
                    "timbang_in"        => $bla[$i]['kode_timbangan_masuk'],
                    "timbang_out"       => $bla[$i]['kode_timbangan_keluar']
                ); 
                Timbangan::create($filedata);
//                Timbangan::insert($filedata);
            }
            return redirect()->route('timbangan')->with('msg','Data berhasil disimpan.');
            
//            if(count($filedata)>0)
//            {
//                print_r($filedata);
//                Timbangan::insert($filedata);
//                return redirect()->route('timbangan')->with('msg','Data berhasil disimpan.');
//            }
//            else
//            {
//                return redirect()->route('timbangan')->with('msg','Tidak ada data yang dimasukkan');
//            }
        }
        return redirect()->route('timbangan')->with('msg','Tidak ada data yang dimasukkan');
    }
    
    public function softdelete($id, CreateTimbanganRequest $request)
    {
        $edit    = Timbangan::where('id_timbangan',$id)->first();
        
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
        
        $datas   = Timbangan::with('barang');      
        
        $datas->where('hapus','1');
        
        if(!empty($req['txtSearch']))
        {
            $datas->where(function($q) use ($req)
            {
                $q->where('tiket','like','%'.$req['txtSearch'].'%');
                $q->orWhere('no_pol','like','%'.$req['txtSearch'].'%');
                $q->orWhere('relasi','like','%'.$req['txtSearch'].'%');
                $q->orWhere('nama_supir','like','%'.$req['txtSearch'].'%');
            });
        }    
        
        if(!empty($req['cmbBarang']))
        {
            $datas->where('id_barang',$req['cmbBarang']);
        } 
        
        if(!empty($req['txtSDate']))
        {
            $sdt = Carbon::createFromFormat('d-m-Y',$req['txtSDate']);
            
            if(!empty($req['txtEDate']))
            {
                $edt = Carbon::createFromFormat('d-m-Y',$req['txtEDate']);
                $datas->where(function($q) use($sdt,$edt)
                {
                    $q->whereBetween('tanggal_masuk',[$sdt->toDateString(),$edt->toDateString()]);
                });
            }
            else
            {
                $datas->where('tanggal_masuk',$sdt->toDateString());
            }
        }
        
        $datas->orderBy('timbangan_id','desc');
//        var_dump($datas);
        return  Datatables::of($datas)
                ->addColumn('action',function($datas)
                {
                    $str  = '<a href="'.route("timbangan.ubah",$datas->timbangan_id).'" class="editrow btn btn-default"><i class="fa fa-edit"></i></a>&nbsp;';
                    $str .= '<a href="'.route("timbangan.hapus",$datas->timbangan_id).'" class="deleterow btn btn-default"><i class="fa fa-minus-circle"></i></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$timbangan_id}}')
                ->make(true);
    }
    
    public function autorelasi(Request $request)
    {
        $ret    = array();
        $datas  = array();
        
        if($request->input('q'))
        {
            $datas = Timbangan::select('relasi')->where('relasi','like','%'.$request->input('q').'%')->groupBy('relasi');
        
            $datas = $datas->orderBy('relasi','asc')->get()->toArray();

            foreach($datas as $data)
            {
                $ret[] = array('id' => $data['relasi'], 'value' => $data['relasi']);
            }
        }
            
        
        echo json_encode($ret);
    }
    
    public function autonopol(Request $request)
    {
        $ret    = array();
        $datas  = array();
        
        if($request->input('q'))
        {
            $datas = Timbangan::select('no_pol')->where('no_pol','like','%'.$request->input('q').'%')->groupBy('no_pol');
        
            $datas = $datas->orderBy('no_pol','asc')->get()->toArray();

            foreach($datas as $data)
            {
                $ret[] = array('id' => $data['no_pol'], 'value' => $data['no_pol']);
            }
        }
            
        
        echo json_encode($ret);
    }
    
    public function autosupir(Request $request)
    {
        $ret    = array();
        $datas  = array();
        
        if($request->input('q'))
        {
            $datas = Timbangan::select('nama_supir')->where('nama_supir','like','%'.$request->input('q').'%')->groupBy('nama_supir');
        
            $datas = $datas->orderBy('nama_supir','asc')->get()->toArray();

            foreach($datas as $data)
            {
                $ret[] = array('id' => $data['nama_supir'], 'value' => $data['nama_supir']);
            }
        }
            
        
        echo json_encode($ret);
    }
    
    public function autotiket(Request $request)
    {
        $ret    = array();
        $datas  = array();
        
        if($request->input('q'))
        {
            $datas = Timbangan::with(['barang' => function($query) use($request)
            {
                if($request->input('k'))
                {
                    $query->where('kode',$request->input('k'));
                }
            }])->where('tiket','like','%'.$request->input('q').'%')->where('hapus','1')->where('print','1');
                                    
            $datas = $datas->orderBy('tiket','asc')->limit(50)->get()->toArray();

            foreach($datas as $data)
            {
                if(isset($data['barang'][0]))
                {
                    $barang = $data['barang'][0];                
    //                print_r($barang);
                    $ret[] = array('id' => $data['tiket'], 
                                   'value' => $data['tiket'],
                                   'tanggal'=>$data['tanggal_masuk'],
                                   'no_pol' => $data['no_pol'],
                                   'jenis' => $barang['kode'],
                                   'brutto' => $data['berat_gross'],
                                   'tara' => $data['berat_tara'],
                                   'netto'  => $data['berat_netto'],
                                   'timbangan_id' => $data['timbangan_id']);
                }
            }
        }
            
        
        echo json_encode($ret);
    }
    
    private function generateTicket($id)
    {
        $kodeBarang  = Barang::where('id_barang',$id)->first();
        
        $getCount    = Timbangan::where('id_barang',$kodeBarang->id_barang)->count();
        
        return $kodeBarang->kode.sprintf("%010s",$getCount+1);
    }
}
