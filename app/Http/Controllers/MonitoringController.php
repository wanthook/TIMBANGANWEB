<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Timbangan as Timbangan;
use App\Barang as Barang;
use Yajra\Datatables\Datatables;

class MonitoringController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }
    
    public function dataTablesTimbangan(Request $request)
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
        
        return  Datatables::of($datas)    
                ->make(true);
    }
    
    public function selectJenisBarang(Request $request)
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
