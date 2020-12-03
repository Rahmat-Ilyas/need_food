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

// LOGIN API
Route::post('login', 'Auth\AuthApiController@login');
Route::post('register', 'Auth\AuthApiController@register');

// LOGIN FOR MOBILE
Route::post('login/mobile', 'Auth\AuthMobileController@loginMobile');

Route::group(['middleware' => 'auth:api'], function(){
	// GET AUTH
    Route::post('getauth', 'Auth\AuthApiController@getauth');
    Route::get('mobileauth/admin/{params}', 'Auth\AuthMobileController@getAdmin');
    Route::get('mobileauth/kitchen/{params}', 'Auth\AuthMobileController@getKitchen');
    Route::get('mobileauth/driver/{params}', 'Auth\AuthMobileController@getDriver');

    // INVENTORI ALAT 
    Route::get('inventori/getalat', 'RestfullApiController@invGetsalat');
    Route::get('inventori/getalat/{id}', 'RestfullApiController@invGetalat');
    Route::get('inventori/getalat/kategori/{id}', 'RestfullApiController@invGetalatkategori');
    Route::post('inventori/setalat', 'RestfullApiController@invSetalat');
    Route::post('inventori/setstokalat', 'RestfullApiController@setStokalat');
    Route::post('inventori/editalat/{id}', 'RestfullApiController@invPutalat');
    Route::delete('inventori/deletealat/{id}', 'RestfullApiController@deleteAlat');

    // INVENTORI BAHAN  
    Route::get('inventori/getbahan', 'RestfullApiController@invGetsbahan');
    Route::get('inventori/getbahan/{id}', 'RestfullApiController@invGetbahan');
    Route::get('inventori/getbahan/kategori/{id}', 'RestfullApiController@invGetbahankategori');
    Route::post('inventori/setbahan', 'RestfullApiController@invSetbahan');
    Route::post('inventori/setstokbahan', 'RestfullApiController@setStokbahan');
    Route::post('inventori/editbahan/{id}', 'RestfullApiController@invPutbahan');
    Route::delete('inventori/deletebahan/{id}', 'RestfullApiController@deleteBahan');

    // KATEGORI
    Route::get('inventori/getkategori', 'RestfullApiController@getsKategori');
    Route::get('inventori/getkategori/{id}', 'RestfullApiController@getKategori');
    Route::post('inventori/setkategori', 'RestfullApiController@setKategori');
    Route::post('inventori/editkategori/{id}', 'RestfullApiController@putKategori');
    Route::delete('inventori/deletekategori/{id}', 'RestfullApiController@deleteKategori');

    // SUPPLIER
    Route::get('getsupplier', 'RestfullApiController@getsSupplier');
    Route::get('getsupplier/{id}', 'RestfullApiController@getSupplier');
    Route::post('setsupplier', 'RestfullApiController@setSupplier');
    Route::put('editsupplier/{id}', 'RestfullApiController@putSupplier');
    Route::delete('deletesupplier/{id}', 'RestfullApiController@deleteSupplier');

    // DRIVER
    Route::post('setdriver', 'RestfullApiController@setDriver');
    Route::post('editdriver/{id}', 'RestfullApiController@putDriver');
    Route::delete('deletedriver/{id}', 'RestfullApiController@deleteDriver');

    // PEMESANAN
    Route::get('datapesanan', 'RestfullApiController@getsPesanan');
    Route::get('datapesanan/{id}', 'RestfullApiController@getPesanan');
    Route::get('datapesanan/status/{status}', 'RestfullApiController@getStatusPesanan');
    Route::post('datapesanan/store', 'RestfullApiController@setPesanan');
    Route::put('datapesanan/updatestatus/{id}', 'RestfullApiController@updateStatusPesanan');
    Route::put('datapesanan/updatedriver/{id}', 'RestfullApiController@updateDriverPesanan');
    Route::put('datapesanan/updatetransaksi/{id}', 'RestfullApiController@updateTransaksiPesanan');

    // PAKET MENU
    Route::get('kelolamenu/getpaket', 'RestfullApiController@getsPaket');
    Route::get('kelolamenu/getpaket/{id}', 'RestfullApiController@getPaket');
    Route::post('kelolamenu/setpaket', 'RestfullApiController@setPaket');


});

Route::fallback(function() {
	return response()->json([
        'success' => false,
        'message' => 'Page Not Found'
    ], 404);
});
