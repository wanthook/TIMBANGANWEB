<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateUserRequest;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    private $menu;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->menu   = $this->parentMenu('user');
    }
    
    /**
     * Show list user
     * 
     * @return void
     */
    public function show()
    {
        return view('admin.user.show',['menu'=>$this->menu]);
    }
    
    
    /**
     * Show form create
     * 
     * @return void
     */
    public function create()
    {
        return view('admin.user.create',['menu'=>$this->menu]);
    }
    
    public function edit($id, User $user)
    {
        $user   = $user->with('modules')->whereId($id)->first();
        
        $mod    = $user->modules->toArray();
        
        $modules    = array();
        
        foreach($mod as $v)
        {
            $modules[]  = $v['id'];
        }
        
        $user->modules  = implode(",", $modules);
        
        return view('admin.user.edit',compact('user'))->with(['menu'=>$this->menu]);
    }
    
    public function save(CreateUserRequest $request, User $user)
    {
        $data   = $request->all();
        $data['password']   = bcrypt($data['password']);
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        
        $save = $user->create($data);
        
        $this->saveDetail($save->id, $data['modules']);
        
        return redirect()->route('user.tabel');
    }
    
    public function update($id, Request $request, User $user)
    {
        $edit    = $user->whereId($id)->first();
       
        $data   = $request->all();
       
        if($data['password'])
            $data['password']   = bcrypt($data['password']);
        else
            unset($data['password']);
           
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        $edit->fill($data)->save();

        $this->saveDetail($id, $data['modules']);

        return redirect()->route('user.tabel');
    }
    
    public function softdelete($id, Request $request, User $user)
    {
        $edit    = $user->whereId($id)->first();
        
        $data    = $request->input();
        
        $data['hapus']    = '0';
        $data['updated_by'] = Auth::user()->id;
        
        $edit->fill($data)->save();
        
        echo json_encode(array('status' => 1, 'msg' => 'Data berhasil dihapus!!!'));
    }
    
    public function dataTables(Request $request, User $user)
    {
        $data   = $user->where('hapus','1');
        
        return  Datatables::of($data)
                ->addColumn('action',function($data)
                {
                    $str  = '<a href="'.route("user.ubah",$data->id).'" class="editrow btn btn-default"><span class="icon-edit"></span></a>&nbsp;';
                    $str .= '<a href="'.route("user.hapus",$data->id).'" class="deleterow btn btn-default"><span class="icon-remove"></span></a>&nbsp;';
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
    public function selectdua(Request $request, User $user)
    {
        $ret    = array();
        $datas  = array();
        if($request->input('id'))
        {
            $datas = $user::find($request->input('id'));
        }
        else
        {
            $datas = $user->where(function($query) use ($request)
                               {
                                    $query->where('name','like','%'.$request->input('q').'%');
                               });
        }
        $datas = $datas->get()->toArray();
        
        foreach($datas as $data)
        {
            $ret[] = array('id' => $data['id'], 'text' => $data['name']);
        }
        
        echo json_encode($ret);
    }
    
    
    private function saveDetail($userId,$moduleId)
    {
        $user = new User;
        
        $usr = $user->whereId($userId)->first();
        
        $mod = explode(',',$moduleId);
        
        $usr->modules()->detach();
        
        $usr->modules()->attach($mod);
        
    }
}
