<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateMesinRequest extends Request
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
        return [
            'mesin_nama'    => 'required|unique:mesin,mesin_nama,null,id,hapus,1',
            'mesin_nomor'   => 'required|unique:mesin,mesin_nomor,null,id,hapus,1',
            'mesin_spindle' => 'required'
        ];
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
           'mesin_nama.required'    => 'Machine name is required.',
           'mesin_nama.unique'      => 'Machine name is already used.',
           'mesin_nomor.required'   => 'Machine number is required.',
           'mesin_nomor.unique'     => 'Machine number is already used.',
           'mesin_spindle.required' => 'Spindle is required.'
       ];
   }
}
