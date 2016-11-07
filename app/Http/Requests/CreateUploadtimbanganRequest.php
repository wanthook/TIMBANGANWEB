<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUploadtimbanganRequest extends Request
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
            'timbangan_excel' => 'required'
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
           'timbangan_excel.required' => 'Pilih file yang akan di-upload.',
           'timbangan_excel.mimes' => 'File harus berekstensi XLSX (Office 2007).'
       ];
   }
}
