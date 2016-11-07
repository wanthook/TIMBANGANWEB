<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateMutasiRequest extends Request
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
                    'tanggal'           => 'required',
                    'tipe'              => 'required',
                    'jenis'             => 'required',
                    'partai'            => 'required',
                    'tiket'             => 'required|unique:mutasi,tiket,null,id,hapus,1',
                    'no_container'      => 'required_if:tipe,import',
                    'no_pol'            => 'required',
                    'bal_list'          => 'required',
                    'bal_terima'        => 'required',
                    'bal_selisih'       => 'required',
                    'packing_tarabl'    => 'required',
                    'packing_brutto'    => 'required',
                    'packing_tara'      => 'required',
                    'packing_subnetto'  => 'required',
                    'timbangan_brutto'  => 'required',
                    'timbangan_tara'    => 'required',
                    'timbangan_netto'   => 'required',
                    'netto'             => 'required',
                    'selisih'           => 'required',
                    'persen'            => 'required',
                    'keterangan'        => 'required',
                    'timbangan_id'      => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
//                $data = Mutasi::find($this->id_barang);
                return [
                    'tanggal'           => 'required',
                    'tipe'              => 'required',
                    'jenis'             => 'required',
                    'partai'            => 'required',
                    'tiket'             => 'required|unique:mutasi,tiket,'.$this->id.',id,hapus,1',
                    'no_container'      => 'required_if:tipe,import',
                    'no_pol'            => 'required',
                    'bal_list'          => 'required',
                    'bal_terima'        => 'required',
                    'bal_selisih'       => 'required',
                    'packing_tarabl'    => 'required',
                    'packing_brutto'    => 'required',
                    'packing_tara'      => 'required',
                    'packing_subnetto'  => 'required',
                    'timbangan_brutto'  => 'required',
                    'timbangan_tara'    => 'required',
                    'timbangan_netto'   => 'required',
                    'netto'             => 'required',
                    'selisih'           => 'required',
                    'persen'            => 'required',
                    'keterangan'        => 'required',
                    'timbangan_id'      => 'required'
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
            'tanggal.required'          => 'Tanggal harus diisi.',
            'tipe.required'             => 'Tipe harus diisi.',
            'jenis.required'            => 'Jenis harus diisi.',
            'partai.required'           => 'Partai harus diisi.',
            'tiket.required'            => 'Tiket harus diisi.',
            'tiket.unique'              => 'Tiket sudah dipilih di database mutasi.',
            'no_container.required_if'  => 'No. Container harus diisi.',
            'no_pol.required'           => 'No. Kendaraan harus diisi.',
            'bal_list.required'         => 'Jumlah Bal List harus diisi.',
            'bal_terima.required'       => 'Jumlah Bal Terima harus diisi.',
            'bal_selisih.required'      => 'Jumlah Bal selisih harus diisi.',
            'packing_tarabl.required'   => 'Jumlah Tara BL harus diisi.',
            'packing_brutto.required'   => 'Packing List Brutto harus diisi.',
            'packing_tara.required'     => 'Packing Tara harus diisi.',
            'packing_subnetto.required' => 'Packing Subnetto harus diisi.',
            'timbangan_brutto.required' => 'Timbangan Brutto harus diisi.',
            'timbangan_tara.required'   => 'Timbangan Tara harus diisi.',
            'timbangan_netto.required'  => 'Timbangan Netto harus diisi.',
            'netto.required'            => 'Netto harus diisi.',
            'selisih.required'          => 'Selisih harus diisi.',
            'persen.required'           => 'Persen harus diisi.',
            'keterangan.required'       => 'Keterangan harus diisi.',
            'timbangan_id.required'     => 'Tiket harus dipilih dengan benar.'
       ];
   }
}
