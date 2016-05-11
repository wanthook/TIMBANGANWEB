<?php
$ext    = '';
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () use ($ext){
    Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
});

Route::group(['middleware' => ['web','auth']], function ()  use ($ext){
    
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
    Route::get('/', ['as' => 'home.root','uses' => 'HomeController@index']);
//    Route::get('/', ['as' => '#','uses' => 'HomeController@index']);
    Route::get('dashboard', ['as' => 'home.dashboard','uses' => 'HomeController@dashboard']);
    
    /*
     * Route buat user
     */
    Route::get('user',                ['as' => 'user.tabel','uses'  => 'UserController@show']);
    Route::post('user',               ['as' => 'user.tabel','uses'  => 'UserController@dataTables']);
    Route::get('user/tambah',         ['as' => 'user.tambah','uses' => 'UserController@create']);
    Route::post('user/tambah',        ['as' => 'user.tambah','uses' => 'UserController@save']);
    Route::get('user/{id}/ubah',      ['as' => 'user.ubah','uses'   => 'UserController@edit']);
    Route::patch('user/{id}/ubah',    ['as' => 'user.ubah','uses'   => 'UserController@update']);
    Route::patch('user/{id}/hapus',   ['as' => 'user.hapus','uses'   => 'UserController@softdelete']);
    //for select2
    Route::post('user/selectdua',        ['as' => 'user.selectdua','uses' => 'UserController@selectdua']);
    Route::post('user/selectduaauthor',        ['as' => 'user.selectduaauthor','uses' => 'UserController@selectduaauthor']);
     
    /*
     * Route buat module
     */
    Route::get('module',                ['as' => 'module.tabel','uses'  => 'ModuleController@show']);
    Route::post('module',               ['as' => 'module.tabel','uses'  => 'ModuleController@dataTables']);
    Route::get('module/tambah',         ['as' => 'module.tambah','uses' => 'ModuleController@create']);
    Route::post('module/tambah',        ['as' => 'module.tambah','uses' => 'ModuleController@save']);
    Route::get('module/{id}/ubah',      ['as' => 'module.ubah','uses'   => 'ModuleController@edit']);
    Route::patch('module/{id}/ubah',    ['as' => 'module.ubah','uses'   => 'ModuleController@update']);
    Route::patch('module/{id}/hapus',   ['as' => 'module.hapus','uses'   => 'ModuleController@softdelete']);
    //for select2
    Route::post('module/selectdua',        ['as' => 'module.selectdua','uses' => 'ModuleController@selectdua']);
    
    /*
     * Route buat mesin
     */
    Route::get('mesin',                ['as' => 'mesin.tabel','uses'  => 'MesinController@show']);
    Route::post('mesin',               ['as' => 'mesin.tabel','uses'  => 'MesinController@dataTables']);
    Route::get('mesin/tambah',         ['as' => 'mesin.tambah','uses' => 'MesinController@create']);
    Route::post('mesin/tambah',        ['as' => 'mesin.tambah','uses' => 'MesinController@save']);
    Route::get('mesin/{id}/ubah',      ['as' => 'mesin.ubah','uses'   => 'MesinController@edit']);
    Route::patch('mesin/{id}/ubah',    ['as' => 'mesin.ubah','uses'   => 'MesinController@update']);
    Route::patch('mesin/{id}/hapus',   ['as' => 'mesin.hapus','uses'   => 'MesinController@softdelete']);
    //for select2
    Route::post('mesin/selectdua',        ['as' => 'mesin.selectdua','uses' => 'MesinController@selectdua']);
    
    /*
     * Route buat snap
     */
    Route::get('snap',                ['as' => 'snap.tabel','uses'  => 'SnapController@show']);
    Route::post('snap',               ['as' => 'snap.tabel','uses'  => 'SnapController@dataTables']);
    Route::get('snap/tambah',         ['as' => 'snap.tambah','uses' => 'SnapController@create']);
    Route::post('snap/tambah',        ['as' => 'snap.tambah','uses' => 'SnapController@save']);
    Route::get('snap/{id}/ubah',      ['as' => 'snap.ubah','uses'   => 'SnapController@edit']);
    Route::patch('snap/{id}/ubah',    ['as' => 'snap.ubah','uses'   => 'SnapController@update']);
    Route::patch('snap/{id}/hapus',   ['as' => 'snap.hapus','uses'   => 'SnapController@softdelete']);
    //for select2
    Route::post('snap/selectdua',        ['as' => 'snap.selectdua','uses' => 'SnapController@selectdua']);
    
});
