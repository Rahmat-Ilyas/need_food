<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','landingpagecontroller@index')->name('page.index');
Route::get('/order','landingpagecontroller@orderindex')->name('page.order.index');
Route::get('/keranjang','landingpagecontroller@keranjang_index')->name('page.keranjang');
// SESSION
Route::get('/getpaket','landingpagecontroller@paket_get')->name('page.paket');
Route::get('/getpaket_to_delivery','landingpagecontroller@paket_get_delivery')->name('page.paket_delivery');
// FRONT
Route::post('/keranjang/paket_pesanan','landingpagecontroller@paket_pesanan')->name('page.pesanan');
Route::post('/keranjang/paket_to_delivery','landingpagecontroller@paket_delivery')->name('page.paketDelivery');
Route::get('/keranjang/detail_alat','landingpagecontroller@detail_alat')->name('page.detail_alat');
Route::get('/pengantaran','landingpagecontroller@pengantaran')->name('page.pengantaran');
Route::get('/konfirmasi/{token}', 'landingpagecontroller@konfirmasi');
Route::get('/done/{token}', 'landingpagecontroller@pesananselesai');

Route::get('/trypemesanan', function() {
	return view('welcome');
});

// Admin
Route::group(['prefix' => 'admin'], function () {
	Route::get('/login', 'Auth\AuthAdminController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AuthAdminController@login')->name('admin.login.submit');
	Route::get('/logout', 'Auth\AuthAdminController@logout')->name('admin.logout');
	Route::get('/', 'AdminController@home')->name('admin.home');

	Route::get('/{page}', 'AdminController@setpageonly');
	Route::get('/{dir}/{page}', 'AdminController@setpagedir');
});

// Dapur
Route::group(['prefix' => 'kitchen'], function () {
	Route::get('/login', 'Auth\AuthKitchenController@showLoginForm')->name('kitchen.login');
	Route::post('/login', 'Auth\AuthKitchenController@login')->name('kitchen.login.submit');
	Route::get('/logout', 'Auth\AuthKitchenController@logout')->name('kitchen.logout');
	Route::get('/', 'KitchenController@home')->name('kitchen.home');

	Route::get('/{page}', 'KitchenController@setpageonly');
	Route::get('/{dir}/{page}', 'KitchenController@setpagedir');
});

Route::post('/configuration', 'ConfigController@config');
Route::get('/datatable', 'ConfigController@datatable');
