<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTimbanganRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
//                    'tiket'             => 'required|unique:timbangan,tiket,null,tiket,hapus,1',
                    'tanggal_masuk'     => 'required',
                    'tanggal_keluar'    => 'required_with:berat_netto',
                    'jam_masuk'         => 'required',
                    'jam_keluar'        => 'required_with:tanggal_keluar,berat_netto',
                    'no_pol'            => 'required',
                    'relasi'            => 'required',
                    'id_barang'         => 'required',
                    'nama_supir'        => 'required',
                    'berat_gross'       => 'required|numeric',
                    'berat_tara'        => 'numeric',
                    'berat_netto'       => 'numeric'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
//                $data = Timbangan::find($this->id_barang);
                return [
//                    'tiket'             => 'required|unique:timbangan,tiket,'.$this->id.',tiket,hapus,1',
                    'tanggal_masuk'     => 'required',
                    'tanggal_keluar'    => 'required_with:berat_netto',
                    'jam_masuk'         => 'required',
                    'jam_keluar'        => 'required_with:tanggal_keluar,berat_nett',
                    'no_pol'            => 'required',
                    'relasi'            => 'required',
                    'id_barang'         => 'required',
                    'nama_supir'        => 'required',
                    'berat_gross'       => 'required|numeric',
                    'berat_tara'        => 'numeric',
                    'berat_netto'       => 'numeric'
                ];
            }
            default:break;
        }
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
            'tanggal_masuk.required'        => 'Tanggal masuk harus diisi.',
            'tanggal_keluar.required_with'       => 'Tanggal keluar harus diisi',
            'jam_masuk.required'            => 'Jam masuk harus diisi.',
            'jam_keluar.required_with'           => 'Jam keluar harus diisi.',
            'no_pol.required'               => 'Nomor polisi harus diisi.',
            'relasi.required'               => 'Relasi harus diisi.',
            'id_barang.required'            => 'Jenis barang harus diisi.',
            'nama_supir.required'           => 'Nama supir harus diisi.',
            'berat_gross.required'          => 'Berat gross harus diisi.',
            'berat_tara.required'           => 'Berat tara harus diisi.',
            'berat_netto.required'          => 'Berat netto harus diisi.',
            'berat_gross.numeric'           => 'Berat gross harus berupa angka',
            'berat_tara.numeric'            => 'Berat tara harus berupa angka',   
            'berat_netto.numeric'           => 'Berat netto harus berupa angka'
       ];
   }
}
