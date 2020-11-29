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
Route::get('/keranjang','landingpageController@keranjang_index')->name('page.keranjang');
Route::get('/keranjang/detail_alat','landingpageController@detail_alat')->name('page.detail_alat');
Route::get('/pengantaran','landingpageController@pengantaran')->name('page.pengantaran');
// Admin
Route::group(['prefix' => 'admin'], function () {
	Route::get('/login', 'Auth\AuthAdminController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AuthAdminController@login')->name('admin.login.submit');
	Route::get('/logout', 'Auth\AuthAdminController@logout')->name('admin.logout');
	Route::get('/', 'AdminController@home')->name('admin.home');

	Route::get('/{page}', 'AdminController@setpageonly');
	Route::get('/{dir}/{page}', 'AdminController@setpagedir');
});

Route::post('/configuration', 'ConfigController@config');
Route::get('/tess', function() {
	echo phpinfo();
});
