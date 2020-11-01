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

Route::post('login', 'Auth\AuthApiController@login');
Route::post('register', 'Auth\AuthApiController@register');

Route::group(['middleware' => 'auth:api'], function(){
	// GET AUTH
    Route::post('getauth', 'Auth\AuthApiController@getauth');

    // INVENTORI ALAT 
    Route::get('inventori/getalat', 'RestfullApiController@invGetsalat');
    Route::get('inventori/getalat/{id}', 'RestfullApiController@invGetalat');
    Route::get('inventori/getalat/kategori/{id}', 'RestfullApiController@invGetalatkategori');
    Route::post('inventori/setalat', 'RestfullApiController@invSetalat');
    Route::post('inventori/setstokalat', 'RestfullApiController@setStokalat');

    // INVENTORI BAHAN  
    Route::get('inventori/getbahan', 'RestfullApiController@invGetsbahan');
    Route::get('inventori/getbahan/{id}', 'RestfullApiController@invGetbahan');
    Route::get('inventori/getbahan/kategori/{id}', 'RestfullApiController@invGetbahankategori');
    Route::post('inventori/setbahan', 'RestfullApiController@invSetbahan');
    Route::post('inventori/setstokbahan', 'RestfullApiController@setStokbahan');

    // KATEGORI
    Route::get('inventori/getkategori', 'RestfullApiController@getsKategori');
    Route::get('inventori/getkategori/{id}', 'RestfullApiController@getKategori');
    Route::post('inventori/setkategori', 'RestfullApiController@setKategori');
    Route::put('inventori/editkategori/{id}', 'RestfullApiController@putKategori');
    Route::delete('inventori/deletekategori/{id}', 'RestfullApiController@deleteKategori');

    // SUPPLIER
    Route::get('getsupplier', 'RestfullApiController@getsSupplier');
    Route::get('getsupplier/{id}', 'RestfullApiController@getSupplier');
    Route::post('setsupplier', 'RestfullApiController@setSupplier');
    Route::put('editsupplier/{id}', 'RestfullApiController@putSupplier');
    Route::delete('deletesupplier/{id}', 'RestfullApiController@deleteSupplier');

    // PEMESANAN
    Route::get('datapesanan', 'RestfullApiController@getsPesanan');
    Route::get('datapesanan/{id}', 'RestfullApiController@getPesanan');
    Route::get('datapesanan/{status}', 'RestfullApiController@getStatusPesanan');
    Route::post('datapesanan/store', 'RestfullApiController@setPesanan');
    Route::put('datapesanan/updatestatus/{id}', 'RestfullApiController@updateStatusPesanan');
    Route::put('datapesanan/updatetransaksi/{id}', 'RestfullApiController@updateTransaksiPesanan');

    // PAKET MENU
    Route::get('kelolamenu/getpaket', 'RestfullApiController@getsPaket');
    Route::get('kelolamenu/getpaket/{id}', 'RestfullApiController@getPaket');
    Route::post('kelolamenu/setpaket', 'RestfullApiController@setPaket');

    // LOGIN FOR MOBILE
    Route::post('login/mobile', 'RestfullApiController@loginMobile');

});

Route::fallback(function() {
	return response()->json(['message' => 'Page Not Found'], 404);
});
