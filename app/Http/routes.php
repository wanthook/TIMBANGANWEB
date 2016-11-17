<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => ['web']], function (){
    Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
//    Route::get('/fmonitoring', ['as' => 'monitoring', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('/oLogin', ['as' => 'oLogin', 'uses' => 'Auth\AuthController@oLogin']);
});

Route::group(['middleware' => ['web','auth']], function (){
    
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
    Route::post('changepass', ['as' => 'changepass', 'uses' => 'Auth\AuthController@changepass']);
    Route::get('/', ['as' => 'home.root','uses' => 'HomeController@index']);
    Route::get('home', ['as' => 'home.root','uses' => 'HomeController@index']);
    
    Route::get('jenisbarang', ['as' => 'jenisbarang', 'uses' => 'BarangController@index']);
    Route::get('jenisbarangadd', ['as' => 'jenisbarang.add', 'uses' => 'BarangController@add']);
    Route::get('jenisbarang/ubah/{id}',    ['as' => 'jenisbarang.ubah','uses'   => 'BarangController@edit']);
    Route::post('jenisbarangdt', ['as' => 'jenisbarang.tabel','uses'  => 'BarangController@dataTables']);
    Route::post('jenisbarangsv', ['as' => 'jenisbarang.save','uses'  => 'BarangController@save']);
    Route::patch('jenisbarang/ubah/{id}',    ['as' => 'jenisbarang.change','uses'   => 'BarangController@change']);
    Route::patch('jenisbarang/hapus/{id}',   ['as' => 'jenisbarang.hapus','uses'   => 'BarangController@softdelete']);
    Route::post('jenisbarangsdua',    ['as' => 'jenisbarang.select2','uses'   => 'BarangController@select2']);
    
    Route::get('timbangan', ['as' => 'timbangan', 'uses' => 'TimbanganController@index']);
    Route::get('timbanganadd', ['as' => 'timbangan.add', 'uses' => 'TimbanganController@add']);
    Route::get('timbanganupload', ['as' => 'timbangan.upload', 'uses' => 'TimbanganController@upload']);
    Route::get('timbangan/ubah/{id}',    ['as' => 'timbangan.ubah','uses'   => 'TimbanganController@edit']);
    Route::post('timbangandt', ['as' => 'timbangan.tabel','uses'  => 'TimbanganController@dataTables']);
    Route::post('timbangansv', ['as' => 'timbangan.save','uses'  => 'TimbanganController@save']);
    Route::post('timbangandu', ['as' => 'timbangan.doupload','uses'  => 'TimbanganController@doupload']);
    Route::patch('timbangan/ubah/{id}',    ['as' => 'timbangan.change','uses'   => 'TimbanganController@change']);
    Route::patch('timbangan/hapus/{id}',   ['as' => 'timbangan.hapus','uses'   => 'TimbanganController@softdelete']);
    Route::patch('timbangan/reset/{id}',   ['as' => 'timbangan.reset','uses'   => 'TimbanganController@reset']);
    Route::post('timbanganautorelasi',    ['as' => 'timbangan.autorelasi','uses'   => 'TimbanganController@autorelasi']);
    Route::post('timbanganautonopol',    ['as' => 'timbangan.autonopol','uses'   => 'TimbanganController@autonopol']);
    Route::post('timbanganautosupir',    ['as' => 'timbangan.autosupir','uses'   => 'TimbanganController@autosupir']);
    Route::post('timbanganautotiket',    ['as' => 'timbangan.autotiket','uses'   => 'TimbanganController@autotiket']);
    
    Route::get('daftarekspedisi', ['as' => 'daftarekspedisi', 'uses' => 'DaftarekspedisiController@index']);
    Route::get('daftarekspedisiadd', ['as' => 'daftarekspedisi.add', 'uses' => 'DaftarekspedisiController@add']);
    Route::get('daftarekspedisi/ubah/{id}',    ['as' => 'daftarekspedisi.ubah','uses'   => 'DaftarekspedisiController@edit']);
    Route::post('daftarekspedisidt', ['as' => 'daftarekspedisi.tabel','uses'  => 'DaftarekspedisiController@dataTables']);
    Route::post('daftarekspedisisv', ['as' => 'daftarekspedisi.save','uses'  => 'DaftarekspedisiController@save']);
    Route::patch('daftarekspedisi/ubah/{id}',    ['as' => 'daftarekspedisi.change','uses'   => 'DaftarekspedisiController@change']);
    Route::delete('daftarekspedisi/hapus/{id}',   ['as' => 'daftarekspedisi.hapus','uses'   => 'DaftarekspedisiController@softdelete']);
    
    Route::get('mutasi/{inout}/{param}', ['as' => 'mutasi', 'uses' => 'MutasiController@index']);
    Route::get('mutasiadd/{inout}/{param}/{type}', ['as' => 'mutasi.add', 'uses' => 'MutasiController@add']);
    Route::get('mutasi/ubah/{inout}/{param}/{id}',    ['as' => 'mutasi.ubah','uses'   => 'MutasiController@edit']);
    Route::post('mutasidt/{inout}/{param}', ['as' => 'mutasi.tabel','uses'  => 'MutasiController@dataTables']);
    Route::post('mutasisv/{inout}/{param}', ['as' => 'mutasi.save','uses'  => 'MutasiController@save']);
    Route::patch('mutasi/ubah/{inout}/{param}/{id}',    ['as' => 'mutasi.change','uses'   => 'MutasiController@change']);
    Route::delete('mutasi/hapus/{inout}/{param}/{id}',   ['as' => 'mutasi.hapus','uses'   => 'MutasiController@softdelete']);
    Route::post('mutasiautopartai/{inout}/{param}',    ['as' => 'mutasi.autopartai','uses'   => 'MutasiController@autopartai']);
    
});