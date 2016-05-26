<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSnapRequest extends Request
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
            'snap_tanggal'  => 'required',
            'snap_shift'   => 'required',
            'mesin_id' => 'required'
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
           'snap_tanggal.required'    => 'Date is required.',
//           'mesin_nama.unique'      => 'Machine name is already used.',
           'snap_shift.required'   => 'Shift is required.',
//           'mesin_nomor.unique'     => 'Machine number is already used.',
           'mesin_id.required' => 'Machine is required.'
       ];
   }
}
