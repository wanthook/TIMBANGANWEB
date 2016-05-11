<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserRequest extends Request
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
            'username'      => 'required|unique:users,username,null,id,hapus,1|regex:/^[a-zA-Z0-9\-_]+$/',
            'name'          => 'required',
            'password'      => 'required|same:password2',
            'email'         => 'email',
            'type'          => 'required',
            'modules'       => 'required'
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
           'username.required'  => 'Username harus diisi.',
           'username.unique'    => 'Username sudah ada di database.',
           'username.regex'     => 'Username harus terdiri dari alphanumeric tanpa spasi.',
           'name.required'      => 'Nama harus diisi.',
           'password.required'  => 'Password harus diisi.',
           'password.same'      => 'Password tidak sama.',
           'email.email'        => 'Alamat email tidak valid.',
           'type.required'      => 'Tipe harus diisi.',
           'modules.required'   => 'Menu harus diisi.'
       ];
   }
}
