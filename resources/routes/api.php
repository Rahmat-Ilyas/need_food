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
Route::post('updateauth', 'Auth\AuthApiController@update');

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
    Route::get('inventori/getalathilang', 'RestfullApiController@invAlathilang');
    Route::post('inventori/setalat', 'RestfullApiController@invSetalat');
    Route::post('inventori/setstokalat', 'RestfullApiController@setStokalat');
    Route::post('inventori/editalat/{id}', 'RestfullApiController@invPutalat');
    Route::post('inventori/setalatkembali/{alathilang_id}', 'RestfullApiController@setAlatkembali');
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
    Route::put('driver/changepassword/{id}', 'RestfullApiController@changePassword');
    Route::delete('deletedriver/{id}', 'RestfullApiController@deleteDriver');
    Route::post('driver/cekalats/{pesanan_id}', 'RestfullApiController@cekAlatsDriver');
    Route::post('driver/cekalat/{pesanan_id}', 'RestfullApiController@cekAlatDriver');
    Route::post('driver/fotopesanan/{pesanan_id}', 'RestfullApiController@fotoPesanan');

    // PEMESANAN
    Route::get('datapesanan', 'RestfullApiController@getsPesanan');
    Route::get('datapesanan/{id}', 'RestfullApiController@getPesanan');
    Route::get('datapesanan/status/{status}', 'RestfullApiController@getStatusPesanan');
    Route::get('datapesanan/pesanan/today', 'RestfullApiController@getPesananToday');
    Route::get('datapesanan/driver/{driver_id}', 'RestfullApiController@getPesananDriver');
    Route::get('datapesanan/getuser/old', 'RestfullApiController@getPesananUserold');
    Route::put('datapesanan/updatestatus/{id}', 'RestfullApiController@updateStatusPesanan');
    Route::put('datapesanan/updatedriver/{id}', 'RestfullApiController@updateDriverPesanan');
    Route::put('datapesanan/uploadbuktipembayaran/{token}', 'RestfullApiController@uploadBuktiPembayaran');
    Route::put('datapesanan/updatetransaksi/{id}', 'RestfullApiController@updateTransaksiPesanan');
    Route::post('datapesanan/store', 'RestfullApiController@setPesanan');
    Route::post('datapesanan/setalatpesanan', 'RestfullApiController@setAlatPesanan');
    Route::post('datapesanan/konfirmasi', 'RestfullApiController@konfirmasiPesanan'); 

    // PAKET MENU
    Route::get('kelolamenu/getpaket', 'RestfullApiController@getsPaket');
    Route::get('kelolamenu/getpaket/{id}', 'RestfullApiController@getPaket');
    Route::post('kelolamenu/setpaket', 'RestfullApiController@setPaket');
    Route::post('kelolamenu/editpaket/{id}', 'RestfullApiController@putPaket');
    Route::delete('kelolamenu/deletepaket/{id}', 'RestfullApiController@deletePaket');
    Route::post('getalatpaket', 'RestfullApiController@getAlatPaket');

    // ADDITIONAL DAGING
    Route::get('kelolamenu/getadditional', 'RestfullApiController@getsAdditional');
    Route::get('kelolamenu/getadditional/{id}', 'RestfullApiController@getAdditional');

    // KEUANGAN
    Route::post('keuangan/create', 'RestfullApiController@setKeuangan');
    Route::get('keuangan/getdata', 'RestfullApiController@getsKeuangan');
    Route::get('keuangan/getdata/{id}', 'RestfullApiController@getKeuangan');
    Route::get('keuangan/datathisweek', 'RestfullApiController@getDatathisWeek');
    Route::put('keuangan/edit/{id}', 'RestfullApiController@putKeuangan');
    Route::delete('keuangan/delete/{id}', 'RestfullApiController@deleteKeuangan');

    // KERITIK & SARAN
    Route::post('kritiksaran/create', 'RestfullApiController@setKritiksaran');
    Route::get('kritiksaran/getdata', 'RestfullApiController@getsKritiksaran');
    Route::get('kritiksaran/getdata/{id}', 'RestfullApiController@getKritiksaran');
    Route::delete('kritiksaran/delete/{id}', 'RestfullApiController@deleteKritiksaran');


});

Route::fallback(function() {
	return response()->json([
        'success' => false,
        'message' => 'Page Not Found'
    ], 404);
});
