<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateDaftarekspedisiRequest extends Request
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
                    'tanggal_pesan'     => 'required',
                    'no_pol'            => 'required',
                    'relasi'            => 'required',
                    'nama_supir'        => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
//                $data = Daftarekspedisi::find($this->id_barang);
                return [
//                    'tiket'             => 'required|unique:timbangan,tiket,'.$this->id.',tiket,hapus,1',
                    'tanggal_pesan'     => 'required',
                    'no_pol'            => 'required',
                    'relasi'            => 'required',
                    'nama_supir'        => 'required'
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
            'tanggal_pesan.required'        => 'Tanggal pesan harus diisi.',
            'no_pol.required'               => 'Nomor polisi harus diisi.',
            'relasi.required'               => 'Relasi harus diisi.',
            'nama_supir.required'           => 'Nama supir harus diisi.'
       ];
   }
}
