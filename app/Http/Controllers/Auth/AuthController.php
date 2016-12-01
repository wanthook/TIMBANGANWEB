<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    public function oLogin(Request $request)
    {
        $ret    = 0;
        $username = $request->input('u');
        $password = $request->input('p');
        
        if(!empty($username) && !empty($password))
        {
//            $data = User::where('hapus',1)->where('username',$username)->whereIn('type',['OPR','ADMIN','GD']);
//            
//            if($data->count()>0)
//            {
//                $datas = $data->first();
//                
//                if(password_verify($password, $datas->password))
//                {
//                    $ret  =  $datas->id;
//                }
//            }
            
        }
        
        echo json_encode($ret);
    }
    
    public function changepass(Request $request)
    {
        $ret = array();
        $data    = $request->all();
        
        if (Auth::attempt(['id' => Auth::user()->id, 'password' => $data->old_password, 'hapus' => 1])) 
        {
            if($data->new_password == $data->retype_password)
            {
                $user = User::findOrFail(Auth::user()->id);
                
                $user->fill([
                    'password' => Hash::make($request->newPassword)
                ])->save();
            }
        }
    }
}
