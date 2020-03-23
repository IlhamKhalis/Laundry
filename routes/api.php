<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::get('/', function(){
    return Auth::user()->level;
})->middleware('jwt.verify');

Route::get('user', 'PetugasController@getAuthenticatedUser')->middleware('jwt.verify');

#pelanggan
Route::post('/simpan_pelanggan', 'PelangganController@store')->middleware('jwt.verify');
Route::put('/ubah_pelanggan/{id}', 'PelangganController@update')->middleware('jwt.verify');
Route::get('/tampil_pelanggan', 'PelangganController@tampil')->middleware('jwt.verify');
Route::get('/index_pelanggan/{id}', 'PelangganController@index')->middleware('jwt.verify');
Route::delete('/hapus_pelanggan/{id}', 'PelangganController@destroy')->middleware('jwt.verify');

#jeniscuci
Route::post('/simpan_jeniscuci', 'JeniscuciController@store')->middleware('jwt.verify');
Route::put('/ubah_jeniscuci/{id}', 'JeniscuciController@update')->middleware('jwt.verify');
Route::get('/tampil_jeniscuci', 'JeniscuciController@tampil')->middleware('jwt.verify');
Route::get('/index_jeniscuci/{id}', 'JeniscuciController@index')->middleware('jwt.verify');
Route::delete('/hapus_jeniscuci/{id}', 'JeniscuciController@destroy')->middleware('jwt.verify');

#transaksi
Route::post('/simpan_transaksi', 'TransaksiController@store')->middleware('jwt.verify');
Route::put('/ubah_transaksi/{id}', 'TransaksiController@update')->middleware('jwt.verify');
Route::post('/tampil_transaksi', 'TransaksiController@show')->middleware('jwt.verify');
Route::delete('/hapus_transaksi/{id}', 'TransaksiController@destroy')->middleware('jwt.verify');

#detail transaksi
Route::post('/simpan_detail', 'DetailtransaksiController@store')->middleware('jwt.verify');
Route::put('/ubah_detail/{id}', 'DetailtransaksiController@update')->middleware('jwt.verify');
Route::delete('/hapus_detail/{id}', 'DetailtransaksiController@destroy')->middleware('jwt.verify');