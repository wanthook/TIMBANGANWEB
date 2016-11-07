<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateBarangRequest extends Request
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
                    'nama_barang'   => 'required',
                    'kode'          => 'required|unique:jenis_barang,kode,null,id_barang,hapus,1'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
//                $data = Barang::find($this->id_barang);
                return [
                    'nama_barang'  => 'required',
                    'kode'          => 'required|unique:jenis_barang,kode,'.$this->id.',id_barang,hapus,1'
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
           'nama_barang.required'    => 'Nama Barang harus diisi.',
           'kode.required'   => 'Kode harus diisi.',
           'kode.unique' => 'Kode sudah ada di database.'
       ];
   }
}
